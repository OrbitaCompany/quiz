const crypto = require('crypto');

const algorithm = 'aes-256-cbc';
const iv = crypto.randomBytes(16); // Vetor de inicialização

// Chave mestra (armazenada apenas no servidor)
const masterKey = process.env.ENCRYPTION_KEY || crypto.randomBytes(32).toString('hex');

function encrypt(text) {
  const cipher = crypto.createCipheriv(algorithm, Buffer.from(masterKey, 'hex'), iv);
  let encrypted = cipher.update(text);
  encrypted = Buffer.concat([encrypted, cipher.final()]);
  return { iv: iv.toString('hex'), encryptedData: encrypted.toString('hex') };
}

function decrypt(encryptedData) {
  const iv = Buffer.from(encryptedData.iv, 'hex');
  const encryptedText = Buffer.from(encryptedData.encryptedData, 'hex');
  const decipher = crypto.createDecipheriv(algorithm, Buffer.from(masterKey, 'hex'), iv);
  let decrypted = decipher.update(encryptedText);
  decrypted = Buffer.concat([decrypted, decipher.final()]);
  return decrypted.toString();
}

module.exports = { encrypt, decrypt };


import { encrypt } from '../../lib/encryption';
import { quizzes } from '../../lib/quiz-templates';

export default function handler(req, res) {
  if (req.method !== 'POST') {
    return res.status(405).json({ error: 'Método não permitido' });
  }

  const { clientKey } = req.body;
  
  if (!clientKey) {
    return res.status(400).json({ error: 'Chave não fornecida' });
  }

  // Verifica se a chave existe e criptografa o quiz correspondente
  if (quizzes[clientKey]) {
    const encryptedQuiz = encrypt(JSON.stringify(quizzes[clientKey]));
    return res.status(200).json({ encryptedQuiz });
  }

  return res.status(404).json({ error: 'Quiz não encontrado para esta chave' });
}

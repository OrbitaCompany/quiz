javascript
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

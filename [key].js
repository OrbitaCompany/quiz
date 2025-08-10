javascript
import { useState, useEffect } from 'react';
import { decrypt } from '../../lib/encryption';
import styles from './Quiz.module.css';

export default function QuizPage() {
  const [quiz, setQuiz] = useState(null);
  const [loading, setLoading] = useState(true);
  const [error, setError] = useState(null);
  const [answers, setAnswers] = useState({});
  const [currentQuestion, setCurrentQuestion] = useState(0);
  const [score, setScore] = useState(null);

  useEffect(() => {
    const key = window.location.pathname.split('/').pop();
    const fetchQuiz = async () => {
      try {
        const response = await fetch('/api/validate-key', {
          method: 'POST',
          headers: { 'Content-Type': 'application/json' },
          body: JSON.stringify({ clientKey: key })
        });
        const data = await response.json();
        if (response.ok) {
          const decryptedQuiz = decrypt(data.encryptedQuiz);
          setQuiz(JSON.parse(decryptedQuiz));
        } else {
          setError(data.error || 'Erro ao carregar o quiz');
        }
      } catch (err) {
        setError('Falha na comunicação com o servidor');
      } finally {
        setLoading(false);
      }
    };
    fetchQuiz();
  }, []);

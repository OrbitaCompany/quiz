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

  const handleAnswer = (questionIndex, answerIndex) => {
    setAnswers(prev => ({ ...prev, [questionIndex]: answerIndex }));
  };

  const calculateScore = () => {
    let correct = 0;
    quiz.questions.forEach((q, i) => {
      if (answers[i] === q.answer) correct++;
    });
    setScore(correct);
  };

  if (loading) return <div className={styles.loading}>Carregando...</div>;
  if (error) return <div className={styles.error}>{error}</div>;
  if (!quiz) return <div className={styles.error}>Quiz não encontrado</div>;

  return (
    <div className={styles.container}>
      <h1 className={styles.title}>{quiz.title}</h1>
      
      {score === null ? (
        <>
          <div className={styles.question}>
            <h3>{quiz.questions[currentQuestion].question}</h3>
            <div className={styles.options}>
              {quiz.questions[currentQuestion].options.map((option, i) => (
                <button
                  key={i}
                  className={`${styles.option} ${answers[currentQuestion] === i ? styles.selected : ''}`}
                  onClick={() => handleAnswer(currentQuestion, i)}
                >
                  {option}
                </button>
              ))}
            </div>
          </div>
          
          <div className={styles.navigation}>
            {currentQuestion > 0 && (
              <button onClick={() => setCurrentQuestion(prev => prev - 1)}>
                Anterior
              </button>
            )}
            
            {currentQuestion < quiz.questions.length - 1 ? (
              <button 
                onClick={() => setCurrentQuestion(prev => prev + 1)}
                disabled={answers[currentQuestion] === undefined}
              >
                Próxima
              </button>
            ) : (
              <button 
                onClick={calculateScore}
                disabled={answers[currentQuestion] === undefined}
              >
                Finalizar
              </button>
            )}
          </div>
        </>
      ) : (
        <div className={styles.result}>
          <h2>Resultado</h2>
          <p>Você acertou {score} de {quiz.questions.length} perguntas</p>
        </div>
      )}
    </div>
  );
}

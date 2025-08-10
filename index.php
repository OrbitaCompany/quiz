<!DOCTYPE html>
<html lang="pt-br">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Quiz Mercado Livre</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    <style>
        :root {
            --ml-yellow: #ffe600;
            --ml-blue: #3483fa;
            --ml-dark: #2d3277;
            --ml-gray: #ebebeb;
            --ml-dark-gray: #999;
        }
        
        body {
            background-color: #f5f5f5;
            font-family: 'Proxima Nova', -apple-system, 'Helvetica Neue', Helvetica, Roboto, Arial, sans-serif;
            min-height: 100vh;
        }
        
        .ml-header {
            background-color: var(--ml-yellow);
            padding: 15px 0;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }
        
        .ml-logo {
            max-height: 40px;
        }
        
        .quiz-container {
            background-color: white;
            border-radius: 8px;
            box-shadow: 0 1px 3px rgba(0,0,0,0.12);
            margin: 30px auto;
            max-width: 800px;
            overflow: hidden;
        }
        
        .quiz-image {
            background: linear-gradient(rgba(0,0,0,0.1), rgba(0,0,0,0.1)), url('https://images.unsplash.com/photo-1607082350899-7e105aa886ae?q=80&w=1470') center/cover;
            height: 250px;
            display: flex;
            align-items: center;
            justify-content: center;
        }
        
        .quiz-content {
            padding: 30px;
        }
        
        .step-indicator {
            display: flex;
            justify-content: space-between;
            margin-bottom: 25px;
            position: relative;
        }
        
        .step-indicator::before {
            content: "";
            position: absolute;
            top: 20px;
            left: 0;
            right: 0;
            height: 4px;
            background-color: var(--ml-gray);
            z-index: 1;
        }
        
        .step {
            position: relative;
            z-index: 2;
            text-align: center;
            width: 40px;
        }
        
        .step-circle {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background-color: var(--ml-gray);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 8px;
            font-weight: bold;
            transition: all 0.3s ease;
        }
        
        .step.active .step-circle {
            background-color: var(--ml-blue);
            transform: scale(1.1);
        }
        
        .step.completed .step-circle {
            background-color: var(--ml-blue);
        }
        
        .step.completed .step-circle::after {
            content: "✓";
        }
        
        .question-text {
            font-size: 1.4rem;
            font-weight: 600;
            margin-bottom: 25px;
            color: var(--ml-dark);
        }
        
        .option-card {
            border: 2px solid var(--ml-gray);
            border-radius: 8px;
            padding: 15px;
            margin-bottom: 15px;
            cursor: pointer;
            transition: all 0.2s ease;
            display: flex;
            align-items: center;
        }
        
        .option-card:hover {
            border-color: var(--ml-blue);
            background-color: rgba(52, 131, 250, 0.05);
        }
        
        .option-card.selected {
            border-color: var(--ml-blue);
            background-color: rgba(52, 131, 250, 0.1);
        }
        
        .option-icon {
            background-color: var(--ml-blue);
            color: white;
            width: 36px;
            height: 36px;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin-right: 15px;
            flex-shrink: 0;
        }
        
        .btn-ml {
            background-color: var(--ml-blue);
            color: white;
            border: none;
            padding: 12px 30px;
            font-weight: 600;
            border-radius: 6px;
            transition: all 0.2s ease;
        }
        
        .btn-ml:hover {
            background-color: #2968c8;
            transform: translateY(-2px);
        }
        
        .btn-ml:disabled {
            background-color: var(--ml-gray);
            cursor: not-allowed;
        }
        
        .ml-footer {
            background-color: var(--ml-dark);
            color: white;
            padding: 30px 0;
            margin-top: 30px;
        }
        
        .footer-logo {
            max-height: 30px;
            margin-bottom: 15px;
        }
        
        .footer-title {
            font-size: 1.1rem;
            font-weight: 600;
            margin-bottom: 15px;
        }
        
        .footer-links a {
            color: #ddd;
            text-decoration: none;
            display: block;
            margin-bottom: 8px;
            transition: color 0.2s;
        }
        
        .footer-links a:hover {
            color: white;
        }
        
        .social-icons a {
            color: white;
            font-size: 1.5rem;
            margin-right: 15px;
        }
        
        .congrats-popup {
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-color: rgba(0,0,0,0.7);
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 1000;
            opacity: 0;
            pointer-events: none;
            transition: opacity 0.3s ease;
        }
        
        .congrats-popup.active {
            opacity: 1;
            pointer-events: all;
        }
        
        .popup-content {
            background-color: white;
            border-radius: 12px;
            padding: 40px;
            text-align: center;
            max-width: 500px;
            width: 90%;
            transform: scale(0.8);
            transition: transform 0.3s ease;
        }
        
        .congrats-popup.active .popup-content {
            transform: scale(1);
        }
        
        .popup-icon {
            margin-bottom: 20px;
        }
        
        .rotating-logo {
            width: 120px;
            height: 120px;
            animation: rotate 2s linear infinite, pulse 1.5s ease-in-out infinite alternate;
        }
        
        @keyframes rotate {
            from { transform: rotate(0deg); }
            to { transform: rotate(360deg); }
        }
        
        @keyframes pulse {
            from { transform: scale(1) rotate(0deg); }
            to { transform: scale(1.1) rotate(10deg); }
        }
        
        @keyframes confetti {
            0% { transform: translateY(0) rotate(0); opacity: 1; }
            100% { transform: translateY(-100px) rotate(360deg); opacity: 0; }
        }
        
        .popup-title {
            font-size: 2rem;
            color: var(--ml-dark);
            margin-bottom: 20px;
            font-weight: 700;
        }
        
        .popup-text {
            font-size: 1.1rem;
            margin-bottom: 30px;
            color: #555;
        }
        
        .quiz-fact {
            background-color: rgba(52, 131, 250, 0.1);
            border-left: 4px solid var(--ml-blue);
            padding: 15px;
            border-radius: 0 4px 4px 0;
            margin-top: 25px;
            font-size: 0.95rem;
        }
        
        .progress-container {
            display: flex;
            align-items: center;
            margin-top: 20px;
        }
        
        .progress-label {
            font-size: 0.9rem;
            color: var(--ml-dark);
            margin-right: 15px;
            white-space: nowrap;
        }
        
        .progress {
            flex-grow: 1;
            height: 8px;
            background-color: var(--ml-gray);
            border-radius: 4px;
            overflow: hidden;
        }
        
        .progress-bar {
            height: 100%;
            background-color: var(--ml-blue);
            transition: width 0.5s ease;
        }
        
        .confetti {
            position: absolute;
            width: 12px;
            height: 12px;
            background-color: #f0f;
            opacity: 0;
            z-index: 2000;
        }
        
        .ml-points {
            background-color: #e6f0ff;
            border-radius: 20px;
            padding: 8px 15px;
            display: inline-flex;
            align-items: center;
            margin-top: 20px;
            font-weight: 600;
            color: var(--ml-blue);
        }
    </style>
</head>
<body>
    <!-- Header -->
    <header class="ml-header">
        <div class="container">
            <img src="https://http2.mlstatic.com/frontend-assets/ml-web-navigation/ui-navigation/5.21.22/mercadolibre/logo__large_plus.png" alt="Mercado Livre Logo" class="ml-logo">
        </div>
    </header>
    
    <!-- Quiz Container -->
    <div class="container">
        <div class="quiz-container">
            <div class="quiz-image">
                <h1 class="text-white fw-bold">Quiz Mercado Livre</h1>
            </div>
            
            <div class="quiz-content">
                <!-- Progress Steps -->
                <div class="step-indicator">
                    <div class="step active" data-step="1">
                        <div class="step-circle">1</div>
                        <div>Início</div>
                    </div>
                    <div class="step" data-step="2">
                        <div class="step-circle">2</div>
                        <div>História</div>
                    </div>
                    <div class="step" data-step="3">
                        <div class="step-circle">3</div>
                        <div>Produtos</div>
                    </div>
                    <div class="step" data-step="4">
                        <div class="step-circle">4</div>
                        <div>Serviços</div>
                    </div>
                    <div class="step" data-step="5">
                        <div class="step-circle">5</div>
                        <div>Final</div>
                    </div>
                </div>
                
                <!-- Question Content -->
                <div id="question-container">
                    <div class="question-text" id="question-text">Em que ano foi fundado o Mercado Livre?</div>
                    
                    <div class="options-container" id="options-container">
                        <div class="option-card" data-value="1">
                            <div class="option-icon"><i class="bi bi-1-circle"></i></div>
                            <div class="option-text">1998</div>
                        </div>
                        <div class="option-card" data-value="2">
                            <div class="option-icon"><i class="bi bi-2-circle"></i></div>
                            <div class="option-text">1999</div>
                        </div>
                        <div class="option-card" data-value="3">
                            <div class="option-icon"><i class="bi bi-3-circle"></i></div>
                            <div class="option-text">2001</div>
                        </div>
                        <div class="option-card" data-value="4">
                            <div class="option-icon"><i class="bi bi-4-circle"></i></div>
                            <div class="option-text">2003</div>
                        </div>
                    </div>
                    
                    <div class="quiz-fact">
                        <i class="bi bi-info-circle me-2"></i> O Mercado Livre é a maior empresa de comércio eletrônico da América Latina, presente em 18 países.
                    </div>
                    
                    <div class="d-flex justify-content-between align-items-center mt-4">
                        <div class="progress-container">
                            <div class="progress-label">Progresso:</div>
                            <div class="progress">
                                <div class="progress-bar" id="quiz-progress" style="width: 20%;"></div>
                            </div>
                        </div>
                        <button class="btn btn-ml" id="next-btn">Próxima <i class="bi bi-arrow-right ms-2"></i></button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <!-- Footer -->
    <footer class="ml-footer">
        <div class="container">
            <div class="row">
                <div class="col-md-4 mb-4">
                    <div class="footer-title">Sobre o Mercado Livre</div>
                    <p>O Mercado Livre é a maior plataforma de comércio eletrônico da América Latina, oferecendo soluções completas para comprar, vender, pagar e enviar produtos.</p>
                    <div class="social-icons">
                        <a href="#"><i class="bi bi-facebook"></i></a>
                        <a href="#"><i class="bi bi-instagram"></i></a>
                        <a href="#"><i class="bi bi-twitter"></i></a>
                        <a href="#"><i class="bi bi-youtube"></i></a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="footer-title">Informações</div>
                    <div class="footer-links">
                        <a href="#"><i class="bi bi-question-circle me-2"></i>Central de Ajuda</a>
                        <a href="#"><i class="bi bi-shield-check me-2"></i>Comprar com segurança</a>
                        <a href="#"><i class="bi bi-star me-2"></i>Mercado Pontos</a>
                        <a href="#"><i class="bi bi-credit-card me-2"></i>Mercado Pago</a>
                    </div>
                </div>
                <div class="col-md-4 mb-4">
                    <div class="footer-title">Links Úteis</div>
                    <div class="footer-links">
                        <a href="#"><i class="bi bi-bag me-2"></i>Trabalhe conosco</a>
                        <a href="#"><i class="bi bi-newspaper me-2"></i>Mercado Livre News</a>
                        <a href="#"><i class="bi bi-building me-2"></i>Investidores</a>
                        <a href="#"><i class="bi bi-globe me-2"></i>Sustentabilidade</a>
                    </div>
                </div>
            </div>
            <hr class="bg-light">
            <div class="text-center pt-3">
                <p class="mb-0">© 2023 Mercado Livre. Todos os direitos reservados.</p>
            </div>
        </div>
    </footer>
    
    <!-- Congratulations Popup -->
    <div class="congrats-popup" id="congrats-popup">
        <div class="popup-content">
            <div class="popup-icon">
                <img src="https://www.startpage.com/av/proxy-image?piurl=https%3A%2F%2Ftse3.mm.bing.net%2Fth%2Fid%2FOIP.s2aqVWUnXDD74Z4cA2A7ugAAAA%3Fr%3D0%26pid%3DApi&sp=1754821644T850d829bdd637e8c7e349b806471fc2926c8d3631c342ca7a80d738055f0c2c0" alt="Mercado Livre Logo" class="rotating-logo">
            </div>
            <h2 class="popup-title">Parabéns!</h2>
            <p class="popup-text">Você completou o quiz sobre o Mercado Livre com sucesso! Continue explorando e aprendendo sobre esta incrível plataforma.</p>
            
            <div class="ml-points">
                <i class="bi bi-star-fill me-2"></i>
                Você ganhou 50 Mercado Pontos!
            </div>
            
            <button class="btn btn-ml mt-4" id="close-popup">Fechar</button>
        </div>
    </div>
    
    <script>
        // Quiz questions and answers
        const quizData = [
            {
                question: "Em que ano foi fundado o Mercado Livre?",
                options: ["1998", "1999", "2001", "2003"],
                correct: 1,
                fact: "O Mercado Livre foi fundado em agosto de 1999 em Buenos Aires, Argentina."
            },
            {
                question: "Qual foi o primeiro país onde o Mercado Livre começou a operar?",
                options: ["Brasil", "Argentina", "México", "Chile"],
                correct: 1,
                fact: "Apesar de ter sido fundado na Argentina, o Mercado Livre expandiu-se rapidamente para o Brasil e outros países da região."
            },
            {
                question: "Qual o nome do serviço de pagamentos do Mercado Livre?",
                options: ["Mercado Pagamentos", "Mercado Pago", "Mercado Wallet", "Mercado Pay"],
                correct: 1,
                fact: "O Mercado Pago foi lançado em 2004 e hoje é uma das maiores fintechs da América Latina."
            },
            {
                question: "Qual destes serviços NÃO faz parte do ecossistema do Mercado Livre?",
                options: ["Mercado Envios", "Mercado Ads", "Mercado Crédito", "Mercado Viagens"],
                correct: 3,
                fact: "O Mercado Livre oferece uma ampla gama de serviços, mas não possui um serviço de viagens."
            },
            {
                question: "Quantos usuários ativos o Mercado Livre tinha em 2022?",
                options: ["78 milhões", "102 milhões", "148 milhões", "182 milhões"],
                correct: 2,
                fact: "Em 2022, o Mercado Livre atingiu a marca de 148 milhões de usuários ativos em toda a América Latina."
            }
        ];
        
        // Quiz state
        let currentQuestion = 0;
        let selectedOption = null;
        let score = 0;
        
        // DOM elements
        const questionText = document.getElementById('question-text');
        const optionsContainer = document.getElementById('options-container');
        const nextBtn = document.getElementById('next-btn');
        const progressBar = document.getElementById('quiz-progress');
        const steps = document.querySelectorAll('.step');
        const congratsPopup = document.getElementById('congrats-popup');
        const closePopupBtn = document.getElementById('close-popup');
        
        // Initialize quiz
        function initQuiz() {
            showQuestion();
            updateProgress();
            updateSteps();
            
            // Event listeners
            optionsContainer.addEventListener('click', (e) => {
                const optionCard = e.target.closest('.option-card');
                if (optionCard) {
                    selectOption(optionCard);
                }
            });
            
            nextBtn.addEventListener('click', nextQuestion);
            closePopupBtn.addEventListener('click', () => {
                congratsPopup.classList.remove('active');
            });
        }
        
        // Show current question
        function showQuestion() {
            const question = quizData[currentQuestion];
            questionText.textContent = question.question;
            
            // Clear options container
            optionsContainer.innerHTML = '';
            
            // Add options
            question.options.forEach((option, index) => {
                const optionElement = document.createElement('div');
                optionElement.classList.add('option-card');
                optionElement.setAttribute('data-value', index);
                
                const iconNumber = index + 1;
                optionElement.innerHTML = `
                    <div class="option-icon"><i class="bi bi-${iconNumber}-circle"></i></div>
                    <div class="option-text">${option}</div>
                `;
                
                optionsContainer.appendChild(optionElement);
            });
            
            // Add fact
            const factElement = document.createElement('div');
            factElement.classList.add('quiz-fact');
            factElement.innerHTML = `<i class="bi bi-info-circle me-2"></i> ${question.fact}`;
            optionsContainer.parentNode.insertBefore(factElement, optionsContainer.nextSibling);
            
            // Reset selected option
            selectedOption = null;
            nextBtn.disabled = true;
        }
        
        // Select an option
        function selectOption(optionCard) {
            // Remove selected class from all options
            document.querySelectorAll('.option-card').forEach(card => {
                card.classList.remove('selected');
            });
            
            // Add selected class to clicked option
            optionCard.classList.add('selected');
            selectedOption = parseInt(optionCard.getAttribute('data-value'));
            nextBtn.disabled = false;
        }
        
        // Move to next question
        function nextQuestion() {
            // Check if an option is selected
            if (selectedOption === null) return;
            
            // Check if answer is correct
            if (selectedOption === quizData[currentQuestion].correct) {
                score++;
            }
            
            // Move to next question or show results
            currentQuestion++;
            
            if (currentQuestion < quizData.length) {
                showQuestion();
                updateProgress();
                updateSteps();
            } else {
                showResults();
            }
        }
        
        // Update progress bar
        function updateProgress() {
            const progress = ((currentQuestion + 1) / quizData.length) * 100;
            progressBar.style.width = `${progress}%`;
        }
        
        // Update step indicators
        function updateSteps() {
            steps.forEach((step, index) => {
                step.classList.remove('active', 'completed');
                
                if (index < currentQuestion) {
                    step.classList.add('completed');
                } else if (index === currentQuestion) {
                    step.classList.add('active');
                }
            });
        }
        
        // Show results
        function showResults() {
            // Show congratulations popup
            congratsPopup.classList.add('active');
            
            // Create confetti effect
            createConfetti();
        }
        
        // Create confetti effect
        function createConfetti() {
            const colors = ['#FFD700', '#FF6B6B', '#4ECDC4', '#FF9F1C', '#2A9D8F'];
            
            for (let i = 0; i < 80; i++) {
                const confetti = document.createElement('div');
                confetti.className = 'confetti';
                confetti.style.backgroundColor = colors[Math.floor(Math.random() * colors.length)];
                confetti.style.left = Math.random() * 100 + 'vw';
                confetti.style.animation = `confetti ${Math.random() * 3 + 2}s ease-out forwards`;
                confetti.style.animationDelay = Math.random() * 2 + 's';
                document.body.appendChild(confetti);
                
                // Remove confetti after animation
                setTimeout(() => {
                    confetti.remove();
                }, 5000);
            }
        }
        
        // Initialize quiz when page loads
        window.addEventListener('DOMContentLoaded', initQuiz);
    </script>
</body>
</html>

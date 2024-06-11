<!doctype html>
<html lang="pt-br">
<head>
    <title>Tratamentos - Clínica Smile</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="style/normalize.css">
    <link rel="stylesheet" href="style/tratamentos.css">
    <link rel="stylesheet" href="style/contatos.css">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
</head>
<body>
    <header class="header">
        <span class="logo-text">Smile Clínica</span>
        <button style="display: none;" class="header__btnMenu"> <i class="fas fa-bars fa-2x"></i> <span class="sr-only">Menu</span></button>
        <nav class="header__nav">
            <ul>
                <li><a href="index.php">Home</a></li>
                <li><a href="projeto_final\index.php">LOGIN</a></li>
                <li><a href="tratamentos.php">TRATAMENTOS</a></li>
                <li><a href="dicas.php">DICAS</a></li>
                <li><a href="contatos.php">CONTATOS</a></li>
            </ul>
        </nav>
    </header>
    
    <section class="hero">
        <div class="container">
            <h1 class="hero__title">Cuide do seu sorriso com a gente</h1>
        </div>
    </section>

    <div class="container">
        <section class="tratamentos">
            <h2>Tratamentos</h2>
            <div class="allcards">
                <div class="card js" onclick="showModal('ortodontia')">
                    <h1>Ortodontia</h1>
                    <img src="img/tratamentosortodontia.png" alt="Ortodontia">
                    
                </div>
                <div class="card js" onclick="showModal('implantodontia')">
                    <h1>Implantodontia</h1>
                    <img src="img/tratamentosimplantodontia.png" alt="Implantodontia">
                    
                </div>
                <div class="card js" onclick="showModal('protese')">
                    <h1>Prótese Dentária</h1>
                    <img src="img/tratamentosprotese.png" alt="Prótese Dentária">
                    
                </div>
                <div class="card js" onclick="showModal('periodontia')">
                    <h1>Periodontia</h1>
                    <img src="img/tratamentosperiodontia.png" alt="Periodontia">
                    
                </div>
                <div class="card js" onclick="showModal('endodontia')">
                    <h1>Endodontia</h1>
                    <img src="img/tratamentoendodontia.png" alt="Endodontia">
                    
                </div>
                <div class="card js" onclick="showModal('cirurgia')">
                    <h1>Cirurgia</h1>
                    <img src="img/tratamentoscirurgiaoral.png" alt="Cirurgia">
                    
                </div>
                <div class="card js" onclick="showModal('clareamento')">
                    <h1>Clareamento Dental</h1>
                    <img src="img/tratamentosclareamento.png" alt="Clareamento Dental">
                    
                </div>
                <div class="card js" onclick="showModal('estetica')">
                    <h1>Estética Dental</h1>
                    <img src="img/tratamentosesteticadental.png" alt="Estética Dental">
                    
                </div>
            </div>
        </section>
    </div>

    <footer class="footer">
        <div class="container">
            <h2 class="footer__logo">Smile Clinica</h2>
            <p>"Na Smile Clinic, cuidamos do seu sorriso com carinho e excelência. Nossa equipe de profissionais altamente qualificados está pronta para transformar sua saúde bucal com tratamentos personalizados. Agende sua consulta e descubra o prazer de sorrir com confiança. Estamos localizados no coração da cidade, oferecendo conforto e tecnologia de ponta. Seu sorriso merece o melhor, venha para a Smile Clinic!"</p>
        </div>
    </footer>

    <div id="modal" class="modal">
        <div class="modal-content">
            <span class="close" onclick="closeModal()">&times;</span>
            <div id="modal-body"></div>
            <button type="button" onclick="closeModal()">Voltar</button>
        </div>
    </div>

    <script src="js/menu.js"></script>
    <script src="js/carousel.js"></script>
    <script src="js/main.js"></script>
    <script>
        const treatments = {
            ortodontia: {
                img: 'img/lampada1.png',
                title: 'Ortodontia',
                description: 'Área da Odontologia que estuda e corrige a posição dos dentes e dos ossos maxilares.'
            },
            implantodontia: {
                img: 'img/lampada2.png',
                title: 'Implantodontia',
                description: 'É a especialidade da Odontologia que visa a recuperar regiões bucais com ausência dentária.'
            },
            protese: {
                img: 'img/lampada3.png',
                title: 'Prótese Dentária',
                description: 'Fixada sobre o implante dentário, a Prótese Dentária assume a função do dente perdido.'
            },
            periodontia: {
                img: 'img/lampada5.png',
                title: 'Periodontia',
                description: 'As doenças do sistema de implantação e suporte de dentes são estudadas e tratadas por dentistas da área.'
            },
            endodontia: {
                img: 'img/lampada6.png',
                title: 'Endodontia',
                description: 'A Odontologia que estuda e trata a polpa dentária, a estrutura interna do dente, é a Endodontia.'
            },
            cirurgia: {
                img: 'img/lampada7.png',
                title: 'Cirurgia',
                description: 'Procedimentos cirúrgicos são comuns nas áreas da Odontologia, realizados no consultório odontológico e hospitalar.'
            },
            clareamento: {
                img: 'img/lampada8.png',
                title: 'Clareamento Dental',
                description: 'O Clareamento Dental é um tratamento estético que corrige dentes manchados e amarelados.'
            },
            estetica: {
                img: 'img/lampada9.png',
                title: 'Estética Dental',
                description: 'A arquitetura do sorriso busca a harmonia dos dentes e causa uma boa primeira impressão.'
            }
        };

        function showModal(treatment) {
            const modal = document.getElementById('modal');
            const modalBody = document.getElementById('modal-body');
            const treatmentData = treatments[treatment];
            modalBody.innerHTML = `
                <img src="${treatmentData.img}" alt="${treatmentData.title}">
                <h1>${treatmentData.title}</h1>
                <p>${treatmentData.description}</p>
            `;
            modal.style.display = 'block';
        }

        function closeModal() {
            const modal = document.getElementById('modal');
            modal.style.display = 'none';
        }

        document.addEventListener('DOMContentLoaded', () => {
            const cards = document.querySelectorAll('.card');
            cards.forEach(card => {
                card.classList.add('show');
            });
        });
    </script>
</body>
</html>

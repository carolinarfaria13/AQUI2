<!DOCTYPE html>
<html lang="pt">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Inscrever em Projeto</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="../../CSS/estilosGERAL.css">
    <link rel="stylesheet" href="../../CSS/estilosCAROLINAeSERGIA.css">
    <link rel="stylesheet" href="../../CSS/estilossergiacosta.css">
</head>
<body class="bodyinscreverprojeto">

<header class="header-fixed">
    <nav>
        <?php include_once ("../../components/cp_navbarbranca.php"); ?>
    </nav>
</header>

<main class="maininscreverprojeto" style="padding-top: 80px;">
    <form>

        <div class="form">
            <label for="nome">Nome Completo</label>
            <input type="text" id="nome" placeholder="Nome Completo" />
        </div>

        <div class="form">
            <label for="data">Data de nascimento</label>
            <input type="text" id="data" placeholder="dd/mm/aaaa" />
        </div>

        <div class="form">
            <label for="telemovel">Número de Telemóvel</label>
            <input type="tel" id="telemovel" placeholder="Número de Telemóvel" />
        </div>

        <div class="form">
            <label for="email">E-mail</label>
            <input type="email" id="email" placeholder="E-mail" />
        </div>

        <div class="form">
            <label for="localizacao">Localização</label>
            <input type="text" id="localizacao" placeholder="Localização Atual" />
        </div>

        <div class="form">
            <label for="motivacao">Motivação para participar no projeto</label>
            <textarea id="motivacao" placeholder="Motivação..."></textarea>
        </div>

        <button type="button" class="btninscreverprojeto">Inscrever</button>

    </form>
</main>

<?php $pagina_ativa = 'projetos'; include_once ("../../components/cp_bottombar.php"); ?>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        document.querySelector('.btninscreverprojeto').addEventListener('click', () => {
            const params = new URLSearchParams(window.location.search);
            const id_projeto = params.get('id');

            const formData = new FormData();
            formData.append('id_projeto', id_projeto);
            formData.append('nome', document.getElementById('nome').value);
            formData.append('data_nascimento', document.getElementById('data').value);
            formData.append('telemovel', document.getElementById('telemovel').value);
            formData.append('email', document.getElementById('email').value);
            formData.append('localizacao', document.getElementById('localizacao').value);
            formData.append('motivacao', document.getElementById('motivacao').value);

            fetch('guardar_inscricao.php', {
                method: 'POST',
                body: formData
            })
                .then(res => res.text())
                .then(text => {
                    console.log(text);
                    const data = JSON.parse(text);
                    if (data.sucesso) {
                        alert('Inscrição realizada com sucesso!');
                        history.back();
                    } else {
                        alert('Erro: ' + data.erro);
                    }
                })
                .catch(err => {
                    console.error('Erro fetch:', err);
                    alert('Erro de ligação');
                });
        });
    });
</script>
<script src="../../js/main.js"></script>
</body>
</html>
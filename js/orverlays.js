
document.addEventListener('DOMContentLoaded', () => {

    function ajustarPadding() {
        const header = document.querySelector('.header-fixed');
        const main = document.querySelector('main');
        if (header && main) {
            main.style.paddingTop = header.offsetHeight + 16 + 'px';
        }
    }

    ajustarPadding();
    window.addEventListener('resize', ajustarPadding);

    window.addEventListener('scroll', () => {
        const header = document.querySelector('.header-fixed');
        if (header) {
            if (window.scrollY > 40) {
                header.classList.add('shrink');
            } else {
                header.classList.remove('shrink');
            }
            ajustarPadding();
        }
    });

    const backdrop = document.getElementById('overlayBackdrop');
    const textarea = document.getElementById('overlayTextarea');
    const btnCancelar = document.getElementById('btnCancelar');
    const btnPublicar = document.getElementById('btnPublicar');
    const btnComentar = document.getElementById('btnComentar');
    const lista = document.querySelector('.comentarios-list') || document.querySelector('.topic-list');
    const titulo = document.querySelector('.comentarios-titulo');

    if (btnComentar) {
        btnComentar.addEventListener('click', () => {
            textarea.value = '';
            backdrop.classList.add('ativo');
        });
    }

    if (btnCancelar) {
        btnCancelar.addEventListener('click', () => {
            backdrop.classList.remove('ativo');
        });
    }

    if (backdrop) {
        backdrop.addEventListener('click', (e) => {
            if (e.target === backdrop) backdrop.classList.remove('ativo');
        });
    }

    if (btnPublicar) {
        btnPublicar.addEventListener('click', () => {
            const texto = textarea.value.trim();
            if (!texto) return;

            const params = new URLSearchParams(window.location.search);
            const id_topico = params.get('id');

            const formData = new FormData();

            if (id_topico) {
                // página de comentários
                formData.append('descricao', texto);
                formData.append('id_topico', id_topico);

                fetch('guardar_comentario.php', {
                    method: 'POST',
                    body: formData
                }).then(res => res.json()).then(data => {
                    if (data.sucesso) {
                        const novoItem = document.createElement('li');
                        novoItem.className = 'comentario-item';
                        novoItem.innerHTML = `
                        <div class="topic-avatar">
                            <img src="../../assets/users/ariana.jpg" alt="Ariana Lopes"/>
                        </div>
                        <div class="comentario-body">
                            <p class="comentario-texto">${texto}</p>
                            <div class="comentario-meta">
                                <span class="topic-meta">@ariana123 | Aveiro | agora</span>
                            </div>
                        </div>
                    `;
                        if (lista) lista.insertBefore(novoItem, lista.firstChild);
                        backdrop.classList.remove('ativo');
                    }
                });
            } else {
                // página do fórum - criar tópico
                formData.append('titulo', texto);

                fetch('guardar_topico.php', {
                    method: 'POST',
                    body: formData
                }).then(res => res.json()).then(data => {
                    if (data.sucesso) {
                        const novoItem = document.createElement('li');
                        novoItem.className = 'topic-item';
                        novoItem.innerHTML = `
                        <div class="topic-body">
                            <p class="topic-titulo">${texto}</p>
                            <span class="topic-meta">@ariana123 | agora</span>
                        </div>
                    `;
                        if (lista) lista.insertBefore(novoItem, lista.firstChild);
                        backdrop.classList.remove('ativo');
                    }
                });
            }
        });
    }


});

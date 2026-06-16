
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
    const lista = document.querySelector('.comentarios-list');
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
                        <div class="topic-stats">
                            <span>0</span>
                            <span class="stat-icon">♡</span>
                        </div>
                    </div>
                </div>
            `;

            if (lista) {
                lista.insertBefore(novoItem, lista.firstChild);
            }

            if (titulo && lista) {
                const total = lista.querySelectorAll('.comentario-item').length;
                titulo.textContent = `Comentários (${total})`;
            }

            backdrop.classList.remove('ativo');
        });
    }

});

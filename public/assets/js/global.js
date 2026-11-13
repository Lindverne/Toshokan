document.addEventListener('DOMContentLoaded', () =>
{
    iniciarBotaoSobre();
    iniciarLogout();
    tratarAlertasAuth();
});

function iniciarBotaoSobre()
{
    const btn = document.createElement('button');
    btn.id                 = 'btnSobreOSite';
    btn.title              = 'Sobre o Site';
    btn.style.width        = '56px';
    btn.style.height       = '56px';
    btn.style.padding      = '0';
    btn.style.overflow     = 'hidden';
    btn.style.borderRadius = '50%';
    btn.style.display       = 'flex';
    btn.style.alignItems    = 'center';
    btn.style.justifyContent = 'center';
    btn.style.position     = 'fixed';
    btn.style.bottom       = '28px';
    btn.style.right        = '28px';
    btn.style.zIndex       = '1050';
    btn.style.border       = 'none';
    btn.style.cursor       = 'pointer';
    btn.style.transition   = 'transform 0.25s ease, box-shadow 0.25s ease';
    btn.style.boxShadow    = '0 4px 16px rgba(61, 90, 128, 0.3)';

    const img       = document.createElement('img');
    img.src         = '../assets/img/global/sobre.jpeg';
    img.alt         = 'Sobre o Site';
    img.style.width        = '100%';
    img.style.height       = '100%';
    img.style.objectFit    = 'cover';
    img.style.borderRadius = '50%';
    btn.appendChild(img);
    document.body.appendChild(btn);

    btn.addEventListener('click', () =>
    {
        Swal.fire({
            title: 'Toshokan',
            imageUrl: '../assets/img/global/sobre.jpeg',
            imageWidth: 150,
            imageHeight: 150,
            imageAlt: 'Sobre o projeto e os desenvolvedores',
            html: `
                <p class="mb-1">Sistema de Gerenciamento de Livros 📚</p>
                <hr>
                <p class="small mb-1 mt-2"><strong>Desenvolvido por:</strong> Matheus Guedes - N° 33</p>
            `,
            confirmButtonText: 'Fechar',
            confirmButtonColor: '#3d5a80',
            customClass: { popup: 'rounded-4 shadow-lg' },
            didOpen: (popup) =>
            {
                const img = popup.querySelector('.swal2-image');
                if (img)
                {
                    img.classList.add('swal2-image-round');
                }
            }
        }).then(() =>
        {
            limparParametrosUrl();
        });
        return;
    });

    btn.addEventListener('mouseenter', () =>
    {
        btn.style.transform = 'scale(1.1)';
        btn.style.boxShadow = '0 6px 20px rgba(61, 90, 128, 0.4)';
    });

    btn.addEventListener('mouseleave', () =>
    {
        btn.style.transform = 'scale(1)';
        btn.style.boxShadow = '0 4px 16px rgba(61, 90, 128, 0.3)';
    });
}

function iniciarLogout()
{
    const btnSair = document.getElementById('btnDeslogarSistema');
    if (!btnSair) return;

    btnSair.addEventListener('click', function (e)
    {
        e.preventDefault();
        Swal.fire({
            title: 'Deseja realmente sair? (・_・;)',
            text: 'Sua sessão atual no painel será encerrada.',
            icon: 'question',
            showCancelButton: true,
            confirmButtonColor: '#dc3545',
            cancelButtonColor: '#6c757d',
            confirmButtonText: 'Sair',
            cancelButtonText: 'Permanecer',
            customClass: { popup: 'rounded-4 shadow-lg' }
        }).then(res =>
        {
            if (res.isConfirmed)
            {
                window.location.href = '../../api/controllers/logout.php';
            }
        });
    });
}

function tratarAlertasAuth()
{
    const urlParams   = new URLSearchParams(window.location.search);
    const loginStatus = urlParams.get('login');
    const cadastro    = urlParams.get('cadastro');
    const logout      = urlParams.get('logout');
    const erro        = urlParams.get('erro');

    if (loginStatus === 'sucesso')
    {
        Swal.fire({
            title: 'Bem-vindo! (≧∇≦)ノ',
            text: 'Login efetuado com sucesso!',
            imageUrl: '../assets/img/global/bem-vindo.jpeg',
            imageWidth: 150,
            imageHeight: 150,
            imageAlt: 'Login realizado',
            confirmButtonText: 'Começar',
            confirmButtonColor: '#3d5a80',
            customClass: { popup: 'rounded-4 shadow-lg' },
            didOpen: (popup) =>
            {
                const img = popup.querySelector('.swal2-image');
                if (img)
                {
                    img.classList.add('swal2-image-round');
                }
            }
        }).then(() =>
        {
            limparParametrosUrl();
        });
        return;
    }

    if (cadastro === 'sucesso')
    {
        Swal.fire({
            title: 'Conta criada! (⌒‿⌒)',
            text: 'Cadastro realizado com sucesso! Faça login para continuar.',
            imageUrl: '../assets/img/global/cadastro.jpeg',
            imageWidth: 150,
            imageHeight: 150,
            imageAlt: 'Cadastro realizado',
            confirmButtonText: 'Ir para Login',
            confirmButtonColor: '#3d5a80',
            customClass: { popup: 'rounded-4 shadow-lg' },
            didOpen: (popup) =>
            {
                const img = popup.querySelector('.swal2-image');
                if (img)
                {
                    img.classList.add('swal2-image-round');
                }
            }
        }).then(() =>
        {
            limparParametrosUrl();
        });
        return;
    }

    if (logout === 'sucesso')
    {
        Swal.fire({
            title: 'Sessão encerrada! (╥﹏╥)',
            text: 'Você saiu do sistema. Até logo!',
            imageUrl: '../assets/img/global/tchau.jpeg',
            imageWidth: 150,
            imageHeight: 150,
            imageAlt: 'Até logo',
            confirmButtonText: 'Ok',
            confirmButtonColor: '#6c757d',
            customClass: { popup: 'rounded-4 shadow-lg' },
            didOpen: (popup) =>
            {
                const img = popup.querySelector('.swal2-image');
                if (img)
                {
                    img.classList.add('swal2-image-round');
                }
            }
        }).then(() =>
        {
            limparParametrosUrl();
        });
        return;
    }

    if (erro)
    {
        Swal.fire({
            icon: 'error',
            title: 'Oops... (>-<)',
            text: decodeURIComponent(erro),
            confirmButtonColor: '#dc3545',
            customClass: { popup: 'rounded-4 shadow-lg' }
        }).then(() =>
        {
            limparParametrosUrl();
        });
    }
}

function limparParametrosUrl()
{
    if (window.history.replaceState)
    {
        window.history.replaceState({}, document.title, window.location.pathname);
    }
}

console.log('%c Toshokan ', 'background: #261834; color: #ffffff; padding: 8px 16px; font-size: 18px; font-weight: bold; border-radius: 8px 0 0 8px;');
console.log('%c Versão 1.0 - Komi', 'background: #261834; color: #ffffff; padding: 8px 16px; font-size: 14px; border-radius: 0 8px 8px 0;');
console.log('%c ', 'padding: 90px; line-height: 90px; border-radius: 50%; background: url(../assets/img/global/devtools.png) no-repeat center; background-size: cover; color: transparent;');

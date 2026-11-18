window.confirmarExclusao = function (id, nome)
{
    Swal.fire({
        title: 'Tem certeza? (º _ º)',
        html: `Deseja realmente excluir <strong>${nome}</strong>?<br><small class="text-muted">Esta ação não pode ser desfeita!</small>`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#dc3545',
        cancelButtonColor: '#6c757d',
        confirmButtonText: 'Sim, deletar!',
        cancelButtonText: 'Cancelar',
        customClass: { popup: 'rounded-4 shadow-lg' }
    }).then(res =>
    {
        if (res.isConfirmed)
        {
            window.location.href = '../../api/controllers/excluir.php?id=' + encodeURIComponent(id);
        }
    });
};

document.addEventListener('DOMContentLoaded', function ()
{
    const status = new URLSearchParams(window.location.search).get('status');

    if (status === 'cadastrado')
    {
        Swal.fire({
            title: 'Sucesso! (⌒‿⌒)',
            text: 'Livro cadastrado perfeitamente!',
            icon: 'success',
            confirmButtonColor: '#261834',
            customClass: { popup: 'rounded-4 shadow-lg' }
        }).then(() => limparParametrosUrl());
    }
    else if (status === 'atualizado')
    {
        Swal.fire({
            title: 'Atualizado! (ノ°∀°)ノ',
            text: 'As alterações foram salvas com sucesso!',
            icon: 'success',
            confirmButtonColor: '#261834',
            customClass: { popup: 'rounded-4 shadow-lg' }
        }).then(() => limparParametrosUrl());
    }
    else if (status === 'deletado')
    {
        Swal.fire({
            title: 'Deletado! (>=<)',
            text: 'O livro foi removido com sucesso!',
            icon: 'success',
            confirmButtonColor: '#261834',
            customClass: { popup: 'rounded-4 shadow-lg' }
        }).then(() => limparParametrosUrl());
    }
});

function abrirZoomLivro(src)
{
    const imgModal = document.getElementById('modalLivroImg');
    const modalEl  = document.getElementById('modalLivroZoom');
    const bsModal  = new bootstrap.Modal(modalEl);

    if (imgModal)
    {
        imgModal.src = src;
    }

    bsModal.show();
}

function limparParametrosUrl()
{
    if (window.history.replaceState)
    {
        window.history.replaceState({}, document.title, window.location.pathname);
    }
}

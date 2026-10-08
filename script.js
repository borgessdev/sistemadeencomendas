const busca = document.getElementById('busca');
busca.addEventListener('input', () => {
  const termo = busca.value.toLowerCase();
  document.querySelectorAll('.pedido').forEach(p => {
    p.style.display = p.dataset.texto.includes(termo) ? '' : 'none';
  });
});

document.querySelectorAll('form.excluir').forEach(f => {
  f.addEventListener('submit', e => {
    if (!confirm('Excluir esta encomenda? Isso não pode ser desfeito.')) e.preventDefault();
  });
});

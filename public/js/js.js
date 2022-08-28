window.addEventListener("load", function () {
    const choices = new Choices('.js-choice', {
        loadingText: 'Cargando...',
        noResultsText: 'No hay resultados',
        noChoicesText: 'No hay opciones para seleccionar',
        itemSelectText: 'Presione para seleccionar'});
});

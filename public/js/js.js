window.addEventListener("load", function () {

    //Choises.js aplicar a clase js-choice
    var slides = document.getElementsByClassName("js-choice");
    for (var i = 0; i < slides.length; i++) {
        newChoisesJs(slides.item(i));
    }

    //Boton agregar a clase add_item_link
    document
            .querySelectorAll('.add_item_link')
            .forEach(btn => {
                btn.addEventListener("click", addFormToCollection)
            });

    //Boton eliminar detalles
    document
            .querySelectorAll('tbody.detalles tr')
            .forEach((item) => {
                addFormDeleteLink(item)
            })
});

const newChoisesJs = (item) => {
    return new Choices(item, {
        loadingText: 'Cargando...',
        noResultsText: 'No hay resultados',
        noChoicesText: 'No hay opciones para seleccionar',
        itemSelectText: 'Presione para seleccionar'
    });
}

const addFormToCollection = (e) => {
    const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);

    const item = document.createElement('tr');

    item.innerHTML = collectionHolder
            .dataset
            .prototype
            .replace(
                    /__name__/g,
                    collectionHolder.dataset.index
                    );
    collectionHolder.insertBefore(item, collectionHolder.firstChild);
    ;

    addFormDeleteLink(item)

    item.querySelectorAll('.js-choice')
            .forEach((item) => {
                newChoisesJs(item)
            })

    collectionHolder.dataset.index++;
};

const addFormDeleteLink = (item) => {
    const removeFormButton = document.createElement('td');
    removeFormButton.innerHTML = '<button class="btn btn-danger btn-sm"><i class="bi bi-trash-fill"></i></button>';
    item.append(removeFormButton);
    removeFormButton.firstChild.addEventListener('click', (e) => {
        e.preventDefault();
        // remove the tr for the form
        if (confirm('¿Está seguro de eliminar?')) {
            item.remove()
        }
    });
}
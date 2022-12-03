  document.addEventListener('DOMContentLoaded', () => {

    document.querySelectorAll('#add-image').forEach(btn => {
      btn.addEventListener("click", addFormToCollection)
    });

  })

  const addFormToCollection = (e) => {
    // const collectionHolder = document.querySelector('.' + e.currentTarget.dataset.collectionHolderClass);
    const inputsCollection = document.querySelectorAll('#ad_images' + e.currentTarget.dataset.collectionHolderClass);
    console.log(inputsCollection);
    const counter = document.querySelector('#widgets-counter');
    const index = counter.value;

    const item = document.createElement('input');

    item = inputsCollection.dataset.prototype.replace(
      /__name__/g,
      inputsCollection.dataset.index
    );

    inputsCollection.appendChild(item);

    inputsCollection.dataset.index++;


  };

  function updateCounter() {
    const count = document.querySelectorAll('#ad_images div.form-group').length;
    document.querySelector('#widgets-counter').val(count);
  }

  // function handleDeleteButtons() {
  //   {
      
  //     $('button[data-action="delete"]').click(() => {
  //       const target = this.dataset.target;
  //     })
  //   }
  // }


  handleDeleteButtons();
  updateCounter();
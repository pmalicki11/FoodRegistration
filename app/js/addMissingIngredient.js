const form = document.getElementById('missingIngredientForm');
const notification = document.getElementById('notification');

notification.className = ['text-center alert'];

form.addEventListener('submit', e => {
  
  e.preventDefault();
  const formData = new FormData(e.target);
  formData.append('token', getCookie('JWT'));

  const url = 'https://pml.software/foodregistration/api/ingredients/addMissing';

  fetch(url, {
    method: 'POST',
    body: formData
  })
  .then(response => {
    if(response.status == 201) {
      informSuccess();
    } else {
      informFailed();
    }
  })
  .catch(error => {
    console.log(error);
  });
});

function informSuccess() {
  console.log('Success');
  notification.innerHTML = 'Added';
  notification.classList.remove('alert-danger');
  notification.classList.add('alert-success');
  hide();
}

function informFailed() {
  console.log('Failed');
  notification.innerHTML = 'Error';
  notification.classList.remove('alert-success');
  notification.classList.add('alert-danger');
  hide();
}

function hide() {
  setTimeout(() => {
    notification.innerHTML = '';
    notification.classList.remove('alert-danger');
    notification.classList.remove('alert-success');
  }, 5000);
};

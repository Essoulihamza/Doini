document.addEventListener('DOMContentLoaded', ready);
function ready() {
    loginForm();
    signUpForm();
    addProject();
}
function loginForm() {
    let formButton = document.getElementById('login-button');
    let form = document.getElementById('login-form');
    let formCloser = form.querySelector('.close-form');
    formButton.addEventListener('click', ()=> {
        form.classList.replace('hidden', 'flex');
    });
    formCloser.addEventListener('click', ()=> {
        form.classList.replace('flex', 'hidden');
    })
}
function signUpForm() {
    let formButton = document.getElementById('signup-button');
    let form = document.getElementById('signup-form');
    let formCloser = form.querySelector('.close-form');
    formButton.addEventListener('click', ()=> {
        form.classList.replace('hidden', 'flex');
    });
    formCloser.addEventListener('click', ()=> {
        form.classList.replace('flex', 'hidden');
    });
}
function addProject() {
    let formButton = document.getElementById('add-project-button');
    let form = document.getElementById('add-project-form');
    let formCloser = form.querySelector('.close-form');
    formButton.addEventListener('click', ()=> {
        form.classList.replace('hidden', 'flex');
    });
    formCloser.addEventListener('click', ()=> {
        form.classList.replace('flex', 'hidden');
    });
}

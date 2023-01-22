document.addEventListener('DOMContentLoaded', ready);
function ready() {
    addProject();
}
function addProject() {
    let formButton = document.getElementById('add-project-button');
    let form = document.getElementById('add-project-form');
    if (form != null) {
        let formCloser = form.querySelector('.close-form');
        formCloser.addEventListener('click', () => {
            form.classList.replace('flex', 'hidden');
        });
        formButton.addEventListener('click', () => {
            form.classList.replace('hidden', 'flex');
        });
    }
}

function fetchProject() {
    let projectRequest = new XMLHttpRequest();
    projectRequest.open('GET', 'http://doini.com/project/display/1');
    projectRequest.onload = function () {
        let x = projectRequest.responseText;
        let ourData = JSON.parse(x);
        console.log(ourData);
        renderHTML(ourData);
    }
    projectRequest.send();
    let projectContainer = document.getElementById('projects-container');
    function renderHTML(data) {
        for (let i = 0; i < data.length; i++) {
            let projectElement = `
            <div class="w-72 h-28 bg-primary rounded px-2 py-2">
            <div class="flex justify-between">
                <p class="text-light text-xl font-semibold cursor-default">${data[i].name}</p>
                <div class="space-x-2">
                    <a href="http://doini.com/page/editProject/${data[i].ID}"><i class="uil uil-setting text-2xl text-light"></i></a>
                    <a href=""><i class="uil uil-arrow-circle-right text-dark text-2xl"></i></a>
                </div>

            </div>
            <div class="flex justify-around cursor-default">
            <div>
                <p>Todo</p>
                <div class="w-9 h-9 bg-light rounded flex justify-center items-center">
                    <p class="text-dark text-center font-bold text-xl ">00</p>
                </div>
            </div>
            <div>
                <p>doing</p>
                <div class="w-9 h-9 bg-light rounded flex justify-center items-center">
                    <p class="text-dark text-center font-bold text-xl">00</p>
                </div>
            </div>
            <div>
                <p>Done</p>
                <div class="w-9 h-9 bg-light rounded flex justify-center items-center">
                    <p class="text-dark text-center font-bold text-xl">00</p>
                </div>
            </div>
            </div>
        </div>
            `;
        }
    }
}



document.addEventListener('DOMContentLoaded', ready);
function ready() {
    fetchTasks();
}

function fetchTasks() {
    let projectId = document.querySelector('h1').id;
    let tasksRequest = new XMLHttpRequest();
    tasksRequest.open('GET', `http://doini.com/task/Display/${projectId}`);
    tasksRequest.onload = function(){
        let data = JSON.parse(tasksRequest.responseText);
        console.log(data);
        renderHTML(data);
    }
    tasksRequest.send();
    function renderHTML(data) {
        let todo = document.getElementById('todo-tasks');
        let doing = document.getElementById('doing-tasks');
        let done = document.getElementById('done-tasks');
        data.forEach(task => {
            let taskHtml = `<div class="task w-full h-fit  bg-light rounded p-1 cursor-move" draggable="true">
            <div class="flex justify-between">
                <div class="flex items-center space-x-2">
                    <p class="text-xl ml-2 border-b border-primary">${task.name}</p>
                    <div class="flex justify-center items-center w-20 bg-indigo-100 rounded-lg h-6" >
                        <p class="text-sm text-dark">${task.deadline}</p>
                    </div>
                </div>
                <div class="space-x-1">
                    <a href="http://doini.com/task/delete/${task.ID}/${task.project}"><i class="uil uil-trash-alt text-indigo-300 text-lg"></i></a>
                    <a href=""><i class="uil uil-edit text-indigo-300 text-lg"></i></a> 
                </div>
            </div>
            <p class="text-sm ml-4 mt-2">${task.description}</p>
        </div>`;
            if(task.state == 'to do') {
                todo.insertAdjacentHTML('beforeend', taskHtml);
            }
        });
    }
}
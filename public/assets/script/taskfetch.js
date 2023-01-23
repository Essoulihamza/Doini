document.addEventListener('DOMContentLoaded', ready);
function  ready() {
    fetchTasks();
    addTask();
    addMultiTask();
    search();
    deadlineLimit();
}
function addTask() {
    let formButton = document.getElementById('add-task-button');
    let form = document.getElementById('add-task-form');
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
function fetchTasks() {
    let projectId = document.querySelector('h1').id;
    let tasksRequest = new XMLHttpRequest();
    tasksRequest.open('GET', `http://doini.com/task/Display/${projectId}`);
    tasksRequest.onload = function(){
        let data = JSON.parse(tasksRequest.responseText);
        renderHTML(data);
    }
    tasksRequest.send();
}
function renderHTML(data) {
    let todo = document.getElementById('todo-tasks');
    let doing = document.getElementById('doing-tasks');
    let done = document.getElementById('done-tasks');
    let doneCount = 0;
    let doingCount = 0;
    let toDoCount = 0;
    todo.innerHTML = "";
    doing.innerHTML = "";
    done.innerHTML = "";
    data.forEach(task => {
        let taskHtml = `<div draggable="true" ondragstart="startDragTask(event);" ondragend="endDropTask(event)" class="task w-full h-fit  bg-light rounded p-1 cursor-move drop-shadow-md"  id="${task.ID}">
        <div class="flex justify-between">
            <div class="flex items-center space-x-2">
                <p  onclick="editTask(event)"  class="task-name text-xl ml-2 border-b border-primary">${task.name}</p>
                <div class="flex justify-center items-center w-20 bg-indigo-100 rounded-lg h-6" >
                    <p  onclick="editTask(event)"  class="task-deadline text-sm text-dark">${task.deadline}</p>
                </div>
            </div>
            <div class="space-x-1">
                <a href="http://doini.com/task/delete/${task.ID}/${task.project}"><i class="uil uil-trash-alt text-indigo-300 text-lg"></i></a>
            </div>
        </div>
        <p style="overflow-wrap: break-word;" onclick="editTask(event)"  class="task-description text-sm ml-4 mt-2 text-clip">${task.description} </p>
    </div>`;
        if(task.state == 'done') {
            done.insertAdjacentHTML('beforeend', taskHtml);
            doneCount++;
        }
        else if(task.state == 'doing') {
            doing.insertAdjacentHTML('beforeend', taskHtml);
            doingCount++;
        }else {
            todo.insertAdjacentHTML('beforeend', taskHtml);
            toDoCount++;
        }
    });
    document.getElementById('doing-count').innerText = doingCount;
    document.getElementById('done-count').innerText = doneCount;
    document.getElementById('todo-count').innerText = toDoCount;

}
function updateData(data){
    let tasksRequest = new XMLHttpRequest();
    tasksRequest.open('POST', 'http://doini.com/task/Edit');
    tasksRequest.send(JSON.stringify(data));
    tasksRequest.onload = function(){
        fetchTasks();
    }
}

function editTask(event){
    let element = event.currentTarget;
    element.setAttribute('contenteditable', 'true');
    let task = element.parentElement;
    while(!task.hasAttribute('draggable')) task = task.parentElement;
    let state= task.parentElement.id;
    if(state === 'doing-tasks') state = 'doing';
    else if(state === 'done-tasks') state = 'done';
    else state = 'to do';
    element.addEventListener('focusout', () => {
        let data = {
            'id': task.id,
            'name': task.querySelector('.task-name').innerHTML,
            'description': task.querySelector('.task-description').innerHTML,
            'deadline': task.querySelector('.task-deadline').innerHTML,
            'state': state,
        };
        updateData(data);
    });
}


function search() {
    let search = document.getElementById('search');
    let projectId = document.querySelector('h1').id;
    search.addEventListener('keyup', ()=>{
        if(search.value != "") {
            let data = {'input': search.value,};
            let tasksRequest = new XMLHttpRequest();
            tasksRequest.open('POST', `http://doini.com/task/search/${projectId}`);
            tasksRequest.send(JSON.stringify(data));
            tasksRequest.onload = function(){
                let data = JSON.parse(tasksRequest.responseText);
                renderHTML(data);
            }
        } else {
            fetchTasks();
        }
    });
    
}

function deadlineLimit(){
    let today = new Date();
    let dd = today.getDate();
    let mm = today.getMonth() + 1;
    let yyyy = today.getFullYear();
    if (dd < 10) dd = '0' + dd;
    if (mm < 10) mm = '0' + mm;
    today = yyyy + '-' + mm + '-' + dd;

    let deadline = document.getElementsByClassName("deadline-input");
    for(let i = 0; i < deadline.length; i++) {
        deadline[i].setAttribute('min', today);
    }
}













// drag and drop
function startDragTask(event){
    let task = event.target;
    task.classList.add('draggable-task');
}

function dragOver(event) {
    event.preventDefault();
}
function dropTask(event) {
    let container = event.target; 
    let projectId = document.querySelector('h1').id;
    let state = container.id;
    if(state === 'doing-tasks') state = 'doing';
    else if(state === 'done-tasks') state = 'done';
    else state = 'to do';
    console.log(state);
    let draggableTask = document.querySelector('.draggable-task');
    if(draggableTask != null) {
         let data = {
            'id': draggableTask.id,
            'name': draggableTask.querySelector('.task-name').innerHTML,
            'description': draggableTask.querySelector('.task-description').innerHTML,
            'deadline': draggableTask.querySelector('.task-deadline').innerHTML,
            'state': state,
            'project': projectId
        }
        container.appendChild(draggableTask);
        updateData(data);
    }
}
function endDropTask(event) {
    let task = event.target;
    task.classList.remove('draggable-task');
}









// add multi tasks
function addMultiTask() {
    let formButton = document.getElementById('add-multi-task-button');
    let form = document.getElementById('add-multi-task-form');
    if (form != null) {
        let counter = form.querySelector('#tasks-counter');
        let formCloser = form.querySelector('.close-form');
        let container = form.querySelector('#container');
        formCloser.addEventListener('click', () => {
            form.classList.replace('flex', 'hidden');
        });
        formButton.addEventListener('click', () => {
            form.classList.replace('hidden', 'flex');
        });
        counter.addEventListener('change', ()=>{
            if(counter.value < 1 || isNaN(counter.value)) {
                counter.value = 1;
            }else if(counter.value > 3) counter.value = 3;
    });
    let taskForm = `<div class="flex flex-col justify-center items-center justify-evenly">
            <p class="border-b border-light text-light">0</p>
            <input type="text"  name="task-name" placeholder="Enter task title"
            class="w-56  h-12 bg-indigo-50 rounded border border-primary focus:outline-none
            px-4 focus:border-2 text-dark">
            <textarea name="description" class="w-56  h-32 bg-indigo-50 rounded border border-primary focus:outline-none
            px-4 focus:border-2 text-dark"  placeholder="Task description" maxlength="255"></textarea>
            <input type="date"  name="deadline"
            class=".deadline-input w-56  h-12 bg-indigo-50 rounded border border-primary focus:outline-none
            px-4 focus:border-2 text-dark">
        
        </div>`;
    

        
    }

}



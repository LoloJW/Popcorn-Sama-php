document.addEventListener("DOMContentLoaded", () =>{
   const textarea = document.getElementById('comment');
   const counter = document.getElementById('txt-counter');
   const maxLength = 1000;

function editCounter(){
        const length = textarea.value.length;
        counter.textContent = `${length} / ${maxLength} caratères`;

        if(length > maxLength) {
            textarea.classList.add('is-invalid');
            counter.classList.add('text-danger');
        } else {
            textarea.classList.remove('is-invalid');
            counter.classList.remove('text-danger');
        }
        
    };
editCounter();

textarea.addEventListener('input', editCounter);
});


let regButton = document.querySelector('.reg-button');
let regForm = document.querySelector('.registration');
regButton.addEventListener('click', (e) => {
    if(regForm.style.display ==='block')
    {
        regForm.style.display = 'none';
        regForm.classList.remove('append-effect')
    }
    else
    {
        regForm.classList.add('append-effect')
        regForm.style.display = 'block';
    }
})
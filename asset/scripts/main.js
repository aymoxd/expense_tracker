const addTransaction = document.querySelector('.add');
const overlay = document.querySelector('.overlay');
const closePopup = document.querySelector('.closePopup');
const transactionPopup = document.querySelector('.popup');
const formBTN = document.querySelector('.formBTN');
const amount = document.querySelector('.amount');
const description = document.querySelector('.description');
const edit = document.getElementById('edit');




/*======================================
         opening popup of add transaction
========================================*/

function openTransactionPopup(){
     transactionPopup.classList.add('active');
     overlay.classList.add('active');
}
function closeTransactionPopup(){
    transactionPopup.classList.remove('active');
     overlay.classList.remove('active');
}


addTransaction.addEventListener('click', openTransactionPopup );
overlay.addEventListener('click', closeTransactionPopup );
closePopup.addEventListener('click', closeTransactionPopup );


// i still should change this code of validation
formBTN.addEventListener('click', ()=>{
     if(amount.value == '' || description.value == ''){   
         alert('all inputs are requied!');
     }else{
          console.log('all good');
     }
});
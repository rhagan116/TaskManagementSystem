
//the code for this calender was created following a tutorial from How to dev https://www.youtube.com/watch?v=OcncrLyddAs
let dueDates=[];

const userID = document.body.getAttribute('data-user-id');
console.log("Current User ID:", userID);
//get the due dates from the taskDate.php file
fetch('taskDate.php')
    .then(response => {
        if (!response.ok){
            throw new Error('Network response was not ok');
        }
        return response.text();  
    })
    .then(text=>{
        console.log('response from taskDate.php', text);
        return JSON.parse(text);
    })

    .then(data => {
        if (!data || data.length === 0) {
            console.log("no due dates found");
        } else {
            dueDates = data;
            console.log("fetched due dates:", dueDates);
            updateCalendar();
        }
    })

    .catch(error => {
        console.error('Error fetching due dates:', error);
    });

//bind the calender button elements to the appropriate variables
const monthYearElement = document.getElementById('monthYear');
const datesElement = document.getElementById('dates');
const prevMonth = document.getElementById('prevMonth');
const nextMonth = document.getElementById('nextMonth');

//get the current date when the user opens the website
let currentDate = new Date();

const updateCalendar = () => {
    //get the current year and month of when the user opens the page to accomodate for leap years 
    const currentYear = currentDate.getFullYear();
    const currentMonth = currentDate.getMonth();

    //set the ammount of days within the month
    const firstDay = new Date(currentYear, currentMonth,0);
    const lastDay = new Date(currentYear, currentMonth + 1, 0);
    const totalDays = lastDay.getDate();
    const firstDayIndex = firstDay.getDay();
    const lastDayIndex = lastDay.getDay();

    //format the different data types that will be involved in the date
    const monthYearString = currentDate.toLocaleString('default', {month: 'long', year: 'numeric'});
    monthYearElement.textContent = monthYearString;
    let datesHTML = '';

    for(let i = firstDayIndex; i > 0; i--){
        const prevDate = new Date(currentYear, currentMonth, 0 - i + 1);

        datesHTML += `<div class ="date inactive">${prevDate.getDate()}</div>`;
    }

    //mark a date with a task in it as 'active' so the appropriate styling can be applied 
    for (let i = 1; i <= totalDays; i++){
        const date = new Date(currentYear, currentMonth, i);
        const dateString = date.toISOString().split('T')[0];
        const isDueDate = dueDates.includes(dateString);
        const activeClass = date.toDateString() === new Date().toDateString() ? 'active' : '';
        const dueClass = isDueDate ? 'dueDate' : '';

        datesHTML += `<div class="date ${activeClass} ${dueClass}">${i}</div>`;

    }

    for (let i = 1; i <= 7 - lastDayIndex; i++) {
        const nextDate = new Date(currentYear, currentMonth + 1, i);

        datesHTML += `<div class="date inactive">${nextDate.getDate()}</div>`;
    }

    datesElement.innerHTML = datesHTML;
}

//when the prevMonth button is clicked on the callender, load data for the previous month
prevMonth.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    updateCalendar();
})

//when the nextMonth button is clicked on the calender, load data for the next month
nextMonth.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    updateCalendar();
})

updateCalendar();

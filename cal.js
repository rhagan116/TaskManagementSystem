
let dueDates=[];

const userID = document.body.getAttribute('data-user-id');
console.log("Current User ID:", userID);

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

const monthYearElement = document.getElementById('monthYear');
const datesElement = document.getElementById('dates');
const prevMonth = document.getElementById('prevMonth');
const nextMonth = document.getElementById('nextMonth');

let currentDate = new Date();

const updateCalendar = () => {
    const currentYear = currentDate.getFullYear();
    const currentMonth = currentDate.getMonth();

    const firstDay = new Date(currentYear, currentMonth,0);
    const lastDay = new Date(currentYear, currentMonth + 1, 0);
    const totalDays = lastDay.getDate();
    const firstDayIndex = firstDay.getDay();
    const lastDayIndex = lastDay.getDay();

    const monthYearString = currentDate.toLocaleString('default', {month: 'long', year: 'numeric'});
    monthYearElement.textContent = monthYearString;
    let datesHTML = '';

    for(let i = firstDayIndex; i > 0; i--){
        const prevDate = new Date(currentYear, currentMonth, 0 - i + 1);

        datesHTML += `<div class ="date inactive">${prevDate.getDate()}</div>`;
    }

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

prevMonth.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() - 1);
    updateCalendar();
})

nextMonth.addEventListener('click', () => {
    currentDate.setMonth(currentDate.getMonth() + 1);
    updateCalendar();
})

updateCalendar();

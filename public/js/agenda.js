document.addEventListener("DOMContentLoaded", function () {
    const monthYear = document.getElementById("month-year");
    const daysContainer = document.getElementById("days");
    const prevButton = document.getElementById("prev");
    const nextButton = document.getElementById("next");
    const agendaList = document.getElementById("agenda-list");

    const months = [
        "Januari",
        "Februari",
        "Maret",
        "April",
        "Mei",
        "Juni",
        "Juli",
        "Agustus",
        "September",
        "Oktober",
        "November",
        "Desember",
    ];

    let nationalHolidays = {};

    let currentDate = new Date();
    let today = new Date();

    function getStatusColor(status) {
        switch (status.toLowerCase()) {
            case "confirmed":
                return "green";
            case "cancel":
                return "red";
            case "tentative":
                return "orange";
            case "draft":
                return "blue";
            case "reschedule":
                return "#FFD43B";
            case "holiday":
                return "red";
            default:
                return "gray";
        }
    }

    async function fetchAgendasByDate(date) {
        try {
            const response = await fetch(`/api/agendas/${date}`);
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            const data = await response.json();

            const holidayName = nationalHolidays[date];
            if (holidayName) {
                data.unshift({
                    id: "holiday",
                    date: date,
                    jam: "",
                    title: holidayName,
                    tempat: "",
                    author: "",
                    status: "holiday",
                });
            }

            return data;
        } catch (error) {
            console.error("Fetch error:", error);
            return [];
        }
    }

    async function renderAgendaItems(selectedDateStr) {
        agendaList.innerHTML = "<p>Loading...</p>";

        const agendas = await fetchAgendasByDate(selectedDateStr);

        agendaList.innerHTML = "";

        if (agendas.length === 0) {
            agendaList.innerHTML = `<p>Tidak ada agenda di tanggal ini.</p>`;
            return;
        }

        agendas.forEach((item) => {
            if (item.status === "holiday") {
                agendaList.innerHTML += `<p style="color: red; font-weight: bold;">Hari Libur Nasional: ${item.title}</p>`;
            } else {
                const statusColor = getStatusColor(item.status);

                const agendaHTML = `
                    <div class="agenda-item">
                        <div style="display: flex; justify-content: space-between; align-items: start;">
                            <div>
                                <p><i class="fa-solid fa-calendar-days" style="color: #78B3CE;"><strong> :</strong></i> ${new Date(
                                    item.date
                                ).toLocaleDateString("id-ID", {
                                    weekday: "long",
                                    year: "numeric",
                                    month: "long",
                                    day: "numeric",
                                })}</p>
                                <p><i class="fa-solid fa-clock" style="color: #78B3CE;"><strong> :</strong></i> ${
                                    item.jam
                                }</p>
                                <p><strong style="color: #78B3CE;">Ket:</strong> ${
                                    item.title
                                }</p>
                                <p><i class="fa-solid fa-location-dot" style="color: #78B3CE;"><strong> :</strong></i> ${
                                    item.tempat
                                }</p>
                                <p><strong style="color: orange;">Agenda:</strong> ${
                                    item.disposition || "N/A"
                                }</p>
                                <p><strong>Oleh:</strong> ${
                                    item.user?.name || "N/A"
                                }</p>
                            </div>
                            <div>
                                <a href="/reschedule/${
                                    item.id
                                }" style="background-color: #FFD43B;" class="btn-circle" title="Reschedule"><i class="fa-solid fa-calendar-days"></i></a>
                                <button style="background-color: #4CAF50;" class="btn-circle"><i class="fa-solid fa-pen-to-square"></i></button>
                                <button style="background-color: #f44336;" class="btn-circle"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </div>
                        <div style="text-align: right; margin-top: 10px;">
                            <span style="background-color: ${statusColor}; color: white; padding: 5px 10px; border-radius: 20px;">
                                ${item.status}
                            </span>
                        </div>
                    </div>
                `;

                agendaList.innerHTML += agendaHTML;
            }
        });
    }

    async function fetchAgendaDates(year, month) {
        try {
            const response = await fetch(
                `/api/agenda-dates?year=${year}&month=${String(
                    month + 1
                ).padStart(2, "0")}`
            );
            if (!response.ok) {
                throw new Error("Network response was not ok");
            }
            const dates = await response.json();
            const datesWithAgenda = new Set();
            dates.forEach((dateStr) => {
                const day = parseInt(dateStr.split("-")[2], 10);
                datesWithAgenda.add(day);
            });
            return datesWithAgenda;
        } catch (error) {
            console.error("Fetch error:", error);
            return new Set();
        }
    }

    async function fetchNationalHolidays(year) {
        console.log("Fetching national holidays for year:", year);
        try {
            const response = await fetch(`/api/national-holidays?year=${year}`);
            if (!response.ok) {
                throw new Error("Failed to fetch national holidays");
            }
            const holidays = await response.json();
            console.log("Received holidays:", holidays);
            nationalHolidays = {};
            holidays.forEach((holiday) => {
                nationalHolidays[holiday.date] = holiday.name;
            });
        } catch (error) {
            console.error("Error fetching national holidays:", error);
            nationalHolidays = {};
        }
    }

    async function renderCalendar(date) {
        const year = date.getFullYear();
        const month = date.getMonth();

        await fetchNationalHolidays(year);

        monthYear.textContent = `${months[month]} ${year}`;
        daysContainer.innerHTML = "";

        const agendaDates = await fetchAgendaDates(year, month);

        let firstDayOfMonth = new Date(year, month, 1).getDay();
        firstDayOfMonth = (firstDayOfMonth + 6) % 7;

        const totalDaysInMonth = new Date(year, month + 1, 0).getDate();

        const prevMonthDaysToShow = firstDayOfMonth;
        const lastDayOfPrevMonth = new Date(year, month, 0).getDate();

        for (let i = prevMonthDaysToShow; i > 0; i--) {
            const dayDiv = document.createElement("div");
            dayDiv.textContent = lastDayOfPrevMonth - i + 1;
            dayDiv.classList.add("fade");
            daysContainer.appendChild(dayDiv);
        }

        for (let i = 1; i <= totalDaysInMonth; i++) {
            const dayDiv = document.createElement("div");
            dayDiv.textContent = i;

            if (agendaDates.has(i)) {
                dayDiv.classList.add("has-agenda");
            }

            if (
                i === today.getDate() &&
                month === today.getMonth() &&
                year === today.getFullYear()
            ) {
                dayDiv.classList.add("today");
            }

            const dateStr = `${year}-${String(month + 1).padStart(
                2,
                "0"
            )}-${String(i).padStart(2, "0")}`;
            if (nationalHolidays[dateStr]) {
                dayDiv.classList.add("holiday");
                dayDiv.title = nationalHolidays[dateStr];
                const dayOfWeek = new Date(year, month, i).getDay();
                if (dayOfWeek === 0 || dayOfWeek === 6) {
                    dayDiv.style.color = "white";
                }
            }

            const dayOfWeek = new Date(year, month, i).getDay();
            if (dayOfWeek === 0 || dayOfWeek === 6) {
                dayDiv.classList.add("red");
            }

            dayDiv.addEventListener("click", () => {
                renderAgendaItems(dateStr);
            });

            daysContainer.appendChild(dayDiv);
        }

        const totalBoxes = prevMonthDaysToShow + totalDaysInMonth;
        if (totalBoxes > 35) {
            daysContainer.style.height = "245px";
        } else {
            daysContainer.style.height = "200px";
        }

        const totalRendered = daysContainer.children.length;
        const remaining = totalRendered % 7 === 0 ? 0 : 7 - (totalRendered % 7);

        for (let i = 1; i <= remaining; i++) {
            const dayDiv = document.createElement("div");
            dayDiv.textContent = i;
            dayDiv.classList.add("fade");
            daysContainer.appendChild(dayDiv);
        }
    }

    prevButton.addEventListener("click", function () {
        let month = currentDate.getMonth() - 1;
        let year = currentDate.getFullYear();
        if (month < 0) {
            month = 11;
            year -= 1;
        }
        currentDate = new Date(year, month, 1);
        renderCalendar(currentDate);
    });

    nextButton.addEventListener("click", function () {
        let month = currentDate.getMonth() + 1;
        let year = currentDate.getFullYear();
        if (month > 11) {
            month = 0;
            year += 1;
        }
        currentDate = new Date(year, month, 1);
        renderCalendar(currentDate);
    });

    renderCalendar(currentDate);

    monthYear.addEventListener("click", function () {
        if (monthYear.querySelector("select")) return;

        const currentText = monthYear.textContent.trim();
        const [currentMonthName, currentYear] = currentText.split(" ");
        const currentMonthIndex = months.indexOf(currentMonthName);
        const thisYear = new Date().getFullYear();

        const wrapper = document.createElement("div");
        wrapper.style.display = "inline-flex";
        wrapper.style.gap = "5px";

        const selectMonth = document.createElement("select");
        months.forEach((m, i) => {
            const option = document.createElement("option");
            option.value = i;
            option.textContent = m;
            if (i === currentMonthIndex) option.selected = true;
            selectMonth.appendChild(option);
        });

        const selectYear = document.createElement("select");
        for (let y = thisYear - 5; y <= thisYear + 5; y++) {
            const option = document.createElement("option");
            option.value = y;
            option.textContent = y;
            if (parseInt(currentYear) === y) option.selected = true;
            selectYear.appendChild(option);
        }

        wrapper.appendChild(selectMonth);
        wrapper.appendChild(selectYear);
        monthYear.innerHTML = "";
        monthYear.appendChild(wrapper);

        const originalMonth = currentMonthIndex;
        const originalYear = parseInt(currentYear);

        function updateIfChanged() {
            const newMonth = parseInt(selectMonth.value);
            const newYear = parseInt(selectYear.value);

            const hasMonthChanged = newMonth !== originalMonth;
            const hasYearChanged = newYear !== originalYear;

            if (hasMonthChanged || hasYearChanged) {
                currentDate = new Date(newYear, newMonth, 1);
                renderCalendar(currentDate);
                monthYear.innerHTML = `${months[newMonth]} ${newYear}`;
            }
        }

        selectMonth.addEventListener("change", updateIfChanged);
        selectYear.addEventListener("change", updateIfChanged);
    });

    const todayStr = today.toISOString().split("T")[0];
    renderAgendaItems(todayStr);
});

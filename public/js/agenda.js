document.addEventListener("DOMContentLoaded", function () {
    const monthYear = document.getElementById("month-year");
    const daysContainer = document.getElementById("days");
    const prevButton = document.getElementById("prev");
    const nextButton = document.getElementById("next");
    const agendaItemsContainer = document.getElementById("agenda-items");
    const filterButtons = document.querySelectorAll(".filter-btn");

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
    let selectedStatus = "all"; // Default filter
    let selectedDate = today.toISOString().split("T")[0]; // Default selected date

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

    async function fetchAgendas(date) {
        // This function now only fetches by date, filtering is done on the client-side from the full list
        try {
            const response = await fetch(`/api/agendas/${date}`);
            if (!response.ok) throw new Error("Network response was not ok");
            let data = await response.json();

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

    async function renderAgendaItems(date) {
        agendaItemsContainer.innerHTML = "<p>Loading...</p>";
        const allAgendas = await fetchAgendas(date);

        const filteredAgendas =
            selectedStatus === "all"
                ? allAgendas
                : allAgendas.filter(
                      (item) =>
                          item.status &&
                          item.status.toLowerCase() === selectedStatus
                  );

        agendaItemsContainer.innerHTML = ""; // Clear previous items

        if (filteredAgendas.length === 0) {
            agendaItemsContainer.innerHTML = `<p>Tidak ada agenda.</p>`;
            return;
        }

        filteredAgendas.forEach((item) => {
            if (item.status === "holiday") {
                agendaItemsContainer.innerHTML += `<p style="color: red; font-weight: bold;">Hari Libur Nasional: ${item.title}</p>`;
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
                                <a href="/agenda/${
                                    item.id
                                }/edit" style="background-color: #4CAF50;" class="btn-circle"><i class="fa-solid fa-pen-to-square"></i></a>
                                <button onclick="deleteAgenda(${
                                    item.id
                                })" style="background-color: #f44336;" class="btn-circle"><i class="fa-solid fa-trash"></i></button>
                            </div>
                        </div>
                        <div style="text-align: right; margin-top: 10px;">
                            <span style="background-color: ${statusColor}; color: white; padding: 5px 10px; border-radius: 20px;">${
                    item.status
                }</span>
                        </div>
                    </div>`;
                agendaItemsContainer.innerHTML += agendaHTML;
            }
        });
    }

    window.deleteAgenda = async function (id) {
        if (confirm("Apakah Anda yakin ingin menghapus agenda ini?")) {
            try {
                const response = await fetch(`/agenda/${id}`, {
                    method: "DELETE",
                    headers: {
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                    },
                });

                if (response.ok) {
                    toastr.success("Agenda berhasil dihapus!");
                    renderAgendaItems(selectedDate); // Re-render the list for the currently selected date
                } else {
                    toastr.error("Gagal menghapus agenda.");
                }
            } catch (error) {
                console.error("Error:", error);
                toastr.error("Terjadi kesalahan saat menghapus.");
            }
        }
    };

    async function fetchAgendaDates(year, month) {
        try {
            const response = await fetch(
                `/api/agenda-dates?year=${year}&month=${String(
                    month + 1
                ).padStart(2, "0")}`
            );
            if (!response.ok) throw new Error("Network response was not ok");
            const dates = await response.json();
            const datesWithAgenda = new Set(
                dates.map((dateStr) => parseInt(dateStr.split("-")[2], 10))
            );
            return datesWithAgenda;
        } catch (error) {
            console.error("Fetch error:", error);
            return new Set();
        }
    }

    async function fetchNationalHolidays(year) {
        try {
            const response = await fetch(`/api/national-holidays?year=${year}`);
            if (!response.ok)
                throw new Error("Failed to fetch national holidays");
            const holidays = await response.json();
            nationalHolidays = {};
            holidays.forEach(
                (holiday) => (nationalHolidays[holiday.date] = holiday.name)
            );
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
        let firstDayOfMonth = (new Date(year, month, 1).getDay() + 6) % 7;
        const totalDaysInMonth = new Date(year, month + 1, 0).getDate();
        const lastDayOfPrevMonth = new Date(year, month, 0).getDate();

        for (let i = firstDayOfMonth; i > 0; i--) {
            const dayDiv = document.createElement("div");
            dayDiv.textContent = lastDayOfPrevMonth - i + 1;
            dayDiv.classList.add("fade");
            daysContainer.appendChild(dayDiv);
        }

        for (let i = 1; i <= totalDaysInMonth; i++) {
            const dayDiv = document.createElement("div");
            dayDiv.textContent = i;
            const dateStr = `${year}-${String(month + 1).padStart(
                2,
                "0"
            )}-${String(i).padStart(2, "0")}`;

            if (agendaDates.has(i)) dayDiv.classList.add("has-agenda");
            if (
                i === today.getDate() &&
                month === today.getMonth() &&
                year === today.getFullYear()
            )
                dayDiv.classList.add("today");
            if (nationalHolidays[dateStr]) {
                dayDiv.classList.add("holiday");
                dayDiv.title = nationalHolidays[dateStr];
            }
            const dayOfWeek = new Date(year, month, i).getDay();
            if (dayOfWeek === 0) dayDiv.classList.add("red");

            dayDiv.addEventListener("click", function () {
                selectedDate = dateStr;
                renderAgendaItems(selectedDate);
            });
            daysContainer.appendChild(dayDiv);
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

    filterButtons.forEach((button) => {
        button.addEventListener("click", () => {
            selectedStatus = button.dataset.status;
            filterButtons.forEach((btn) => btn.classList.remove("active"));
            button.classList.add("active");
            renderAgendaItems(selectedDate);
        });
    });

    prevButton.addEventListener("click", () => {
        currentDate.setMonth(currentDate.getMonth() - 1);
        renderCalendar(currentDate);
    });

    nextButton.addEventListener("click", () => {
        currentDate.setMonth(currentDate.getMonth() + 1);
        renderCalendar(currentDate);
    });

    renderCalendar(currentDate);
    renderAgendaItems(selectedDate);
});

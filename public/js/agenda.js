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

    let currentDate = new Date();
    let today = new Date();
    let selectedStatus = "all";
    let nationalHolidays = {};
    let monthlyAgendas = [];

    // --- HELPER FUNCTIONS ---

    function getStatusColor(status) {
        switch (status.toLowerCase()) {
            case "confirm":
                return "green";
            case "cancel":
                return "red";
            case "tentative":
                return "orange";
            case "draft":
                return "blue";
            case "reschedule":
                return "#FFD43B";
            default:
                return "gray";
        }
    }

    // --- API FETCHING FUNCTIONS ---

    async function fetchMonthlyAgendas(year, month) {
        try {
            const response = await fetch(
                `/api/agendas-for-month?year=${year}&month=${month + 1}`
            );
            if (!response.ok)
                throw new Error("Gagal mengambil data agenda bulanan.");
            monthlyAgendas = await response.json();
        } catch (error) {
            console.error("Fetch error:", error);
            monthlyAgendas = [];
        }
    }

    async function fetchNationalHolidays(year) {
        try {
            const response = await fetch(`/api/national-holidays?year=${year}`);
            if (!response.ok)
                throw new Error("Gagal mengambil data hari libur.");
            const holidays = await response.json();
            nationalHolidays = {};
            holidays.forEach((holiday) => {
                nationalHolidays[holiday.date] = holiday.name;
            });
        } catch (error) {
            console.error("Error fetching national holidays:", error);
            nationalHolidays = {};
        }
    }

    // --- RENDERING FUNCTIONS ---

    function renderAgendaItems(day = null) {
        // --- AWAL PERBAIKAN LOGIKA ---
        const year = currentDate.getFullYear();
        const month = currentDate.getMonth() + 1;
        const fullDateStr = day
            ? `${year}-${String(month).padStart(2, "0")}-${String(day).padStart(
                  2,
                  "0"
              )}`
            : null;

        // Cek apakah tanggal yang diklik adalah hari libur
        if (day && nationalHolidays[fullDateStr]) {
            agendaItemsContainer.innerHTML = `<div class="holiday-description">
                <p>${new Date(fullDateStr).toLocaleDateString("id-ID", {
                    weekday: "long",
                    year: "numeric",
                    month: "long",
                    day: "numeric",
                })}</p>
                <h3>Hari Libur Nasional:</h3>
                <h2>${nationalHolidays[fullDateStr]}</h2>
            </div>`;
            return;
        }
        // --- AKHIR PERBAIKAN LOGIKA ---

        let agendasToRender = monthlyAgendas;

        if (day) {
            agendasToRender = monthlyAgendas.filter(
                (item) => item.date === fullDateStr
            );
        }

        const filteredAgendas =
            selectedStatus === "all"
                ? agendasToRender
                : agendasToRender.filter(
                      (item) =>
                          item.status &&
                          item.status
                              .toLowerCase()
                              .replace("confirmed", "confirm") ===
                              selectedStatus.replace("confirmed", "confirm")
                  );

        agendaItemsContainer.innerHTML = "";

        if (filteredAgendas.length === 0) {
            const isTema4 =
                document.documentElement.getAttribute("data-theme-active") ===
                "tema4";
            agendaItemsContainer.innerHTML = `<p style="color:${
                isTema4 ? "#fff" : ""
            };">Tidak ada agenda untuk ditampilkan.</p>`;
            return;
        }

        filteredAgendas.forEach((item) => {
            const statusColor = getStatusColor(item.status);
            // Deteksi tema aktif
            const isTema4 =
                document.documentElement.getAttribute("data-theme-active") ===
                "tema4";
            const iconColor = isTema4 ? "var(--secondary)" : "var(--primary)";
            const agendaHTML = `
                <div class="agenda-item">
                    <div style="display: flex; justify-content: space-between; align-items: start;">
                        <div>
                            <p><i class="fa-solid fa-calendar-days" style="color: ${iconColor};"></i> <strong>:</strong> ${new Date(
                item.date
            ).toLocaleDateString("id-ID", {
                weekday: "long",
                year: "numeric",
                month: "long",
                day: "numeric",
            })}</p>
                                            <p><i class="fa-solid fa-clock" style="color: ${iconColor};"></i> <strong>:</strong> ${
                item.jam
            }</p>
                                            <p><strong style="color: ${iconColor};">Ket:</strong> ${
                item.title
            }</p>
                                            <p><i class="fa-solid fa-location-dot" style="color: ${iconColor};"></i> <strong>:</strong> ${
                item.tempat
            }</p>
                            <p><strong style="color: orange;">Disposisi:</strong> ${
                                item.disposition || "N/A"
                            }</p>
                            <p><strong>Oleh:</strong> ${
                                item.user?.name || "N/A"
                            }</p>
                        </div>
                        <div>
                            <a href="/reschedule/${
                                item.id
                            }" class="btn-circle" style="background-color: #FFD43B;" title="Reschedule"><i class="fa-solid fa-calendar-days"></i></a>
                            <a href="/agenda/${
                                item.id
                            }/edit" class="btn-circle" style="background-color: #4CAF50;" title="Edit"><i class="fa-solid fa-pen-to-square"></i></a>
                            <button onclick="deleteAgenda(${
                                item.id
                            })" class="btn-circle" style="background-color: #f44336;" title="Hapus"><i class="fa-solid fa-trash"></i></button>
                        </div>
                    </div>
                    <div style="text-align: right; margin-top: 10px;">
                        <span style="background-color: ${statusColor}; color: white; padding: 5px 10px; border-radius: 20px;">${
                item.status
            }</span>
                    </div>
                </div>`;
            agendaItemsContainer.innerHTML += agendaHTML;
        });
    }

    async function renderCalendar(date) {
        const year = date.getFullYear();
        const month = date.getMonth();

        monthYear.textContent = `${months[month]} ${year}`;
        daysContainer.innerHTML = "";

        // Ambil data agenda dan hari libur secara paralel
        await Promise.all([
            fetchNationalHolidays(year),
            fetchMonthlyAgendas(year, month),
        ]);
        renderAgendaItems();

        const agendaDates = new Set(
            monthlyAgendas.map((agenda) =>
                parseInt(agenda.date.split("-")[2], 10)
            )
        );
        const firstDayOfMonth = (new Date(year, month, 1).getDay() + 6) % 7;
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
            const dayOfWeek = new Date(year, month, i).getDay();

            const isTema4 =
                document.documentElement.getAttribute("data-theme-active") ===
                "tema4";
            if (agendaDates.has(i)) {
                dayDiv.classList.add("has-agenda");
                if (isTema4) {
                    dayDiv.style.backgroundColor = "#383187";
                    dayDiv.style.color = "#fff";
                    dayDiv.style.borderRadius = "6px";
                }
            }
            if (
                i === today.getDate() &&
                month === today.getMonth() &&
                year === today.getFullYear()
            )
                dayDiv.classList.add("today");

            if (nationalHolidays[dateStr]) {
                dayDiv.classList.add(
                    dayOfWeek === 0 || dayOfWeek === 6
                        ? "holiday-weekend"
                        : "holiday"
                );
                dayDiv.title = nationalHolidays[dateStr];
            } else if (dayOfWeek === 0 || dayOfWeek === 6) {
                dayDiv.classList.add("red");
            }

            dayDiv.addEventListener("click", () => renderAgendaItems(i));
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

    window.deleteAgenda = async function (id) {
        if (confirm("Apakah Anda yakin ingin menghapus agenda ini?")) {
            try {
                const response = await fetch(`/agenda/${id}`, {
                    method: "DELETE",
                    headers: {
                        // Pastikan meta tag ini ada di layout Anda
                        "X-CSRF-TOKEN": document
                            .querySelector('meta[name="csrf-token"]')
                            .getAttribute("content"),
                        Accept: "application/json",
                        "Content-Type": "application/json",
                    },
                });

                // response.ok akan true jika status HTTP adalah 200-299
                if (response.ok) {
                    toastr.success("Agenda berhasil dihapus!");
                    renderCalendar(currentDate); // Muat ulang kalender untuk menampilkan perubahan
                } else {
                    // Tangani jika ada eror dari server
                    const errorData = await response.json();
                    toastr.error(
                        errorData.message || "Gagal menghapus agenda."
                    );
                }
            } catch (error) {
                console.error("Error:", error);
                toastr.error("Terjadi kesalahan koneksi.");
            }
        }
    };

    // --- EVENT LISTENERS ---

    filterButtons.forEach((button) => {
        button.addEventListener("click", () => {
            selectedStatus = button.dataset.status;
            filterButtons.forEach((btn) => btn.classList.remove("active"));
            button.classList.add("active");
            renderAgendaItems();
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

    // --- INITIALIZATION ---

    renderCalendar(currentDate);
});

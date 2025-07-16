document.addEventListener("DOMContentLoaded", () => {
    const themeOptions = document.querySelectorAll(".theme-option");
    const htmlElement = document.documentElement; // Target elemen <html>

    // Fungsi untuk menandai tema yang aktif secara visual di halaman settings
    const setActiveThemeUI = (themeName) => {
        themeOptions.forEach((option) => {
            option.classList.remove("active-theme");
        });

        const activeOption = document.querySelector(
            `.theme-option[data-theme="${themeName}"]`
        );
        if (activeOption) {
            activeOption.classList.add("active-theme");
        }
    };

    // Event listener untuk setiap pilihan tema
    themeOptions.forEach((option) => {
        option.addEventListener("click", () => {
            const themeName = option.getAttribute("data-theme");

            // 1. Simpan pilihan ke localStorage
            localStorage.setItem("selectedTheme", themeName);

            // 2. Terapkan atribut tema ke <html> agar perubahan langsung terlihat
            htmlElement.setAttribute("data-theme-active", themeName);

            // 3. Perbarui tampilan UI di halaman settings
            setActiveThemeUI(themeName);
        });
    });

    // Saat halaman settings dimuat, tandai tema yang sedang aktif
    const currentTheme = localStorage.getItem("selectedTheme") || "tema1";
    setActiveThemeUI(currentTheme);
});

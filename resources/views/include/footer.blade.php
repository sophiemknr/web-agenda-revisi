<footer>
    <p>Copyright &copy; {{ date('Y') }} Kominfo Kota Bogor</p>
</footer>

<style>
    .main-wrapper {
        display: flex;
        flex-direction: column;
        min-height: 100vh;
        width: 100%;
    }

    .main {
        flex-grow: 1;
    }

    footer {
        width: 100%;
        text-align: center;
        padding: 20px 0;
        color: var(--gray);
        background-color: var(--background);
        flex-shrink: 0;
    }
</style>

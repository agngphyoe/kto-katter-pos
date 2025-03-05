function clearLocalStorage() {
    localStorage.clear();

    window.onpageshow = function (event) {
        if (event.persisted) {
            localStorage.clear();
        }
    };
}

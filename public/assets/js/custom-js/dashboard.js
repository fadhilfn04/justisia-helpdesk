document.addEventListener("DOMContentLoaded", function () {
    function updateAgenOnline() {
        fetch("{{ route('dashboard.agenOnline') }}")
            .then(response => response.json())
            .then(data => {
                document.getElementById('agen-online-count').innerText = data.agen_online;
                document.getElementById('total-agen-text').innerText = `dari ${data.total_agen} total agen`;
            })
            .catch(error => console.error('Error fetching agen online data:', error));
    }

    updateAgenOnline();
    setInterval(updateAgenOnline, 2000);
});

document.getElementById('chatButton').addEventListener('click', function () {
    const chatBox = document.getElementById('chatBox');
    chatBox.classList.add('active');
    this.style.display = 'none';
});

document.getElementById('closeChat').addEventListener('click', function () {
    const chatBox = document.getElementById('chatBox');
    chatBox.classList.remove('active');
    setTimeout(() => {
        document.getElementById('chatButton').style.display = 'flex';
    }, 400); 
});

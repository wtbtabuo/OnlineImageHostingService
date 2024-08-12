document.getElementById('imageInput').addEventListener('change', function(event) {
    const file = event.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('imagePreview').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        }
        reader.readAsDataURL(file);
    }
});

document.getElementById('uploadButton').addEventListener('click', function() {
    const fileInput = document.getElementById('imageInput');
    const titleInput = document.getElementById('titleInput').value;
    const uid = uuid.v4();

    if (fileInput.files.length === 0 || titleInput.trim() === "") {
        alert("Please select an image and enter a title.");
        return;
    }

    const file = fileInput.files[0];
    const formData = new FormData();
    formData.append('image', file);
    formData.append('title', titleInput);
    formData.append('uid', uid);

    fetch('http://127.0.0.1:8000/api/image', {
        method: 'POST',
        body: formData
    })
    .then(response => response.json())
    .then(data => {
        alert('Image uploaded successfully!');
    })
    .catch(error => {
        console.error('Error uploading image:', error);
    });
});
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
        if (data.imageId) {
            alert('Image uploaded successfully!');
            
            // 画像のタイプ（拡張子）を取得
            const fileType = file.name.split('.').pop();
            // 2つのURLを生成
            const viewUrl = `http://localhost:5500/Views/index.html/${fileType}/${uid}`;
            const deleteUrl = `http://localhost:5500/Views/index.html/${fileType}/${uid}/delete`;

            // URLを表示するための要素を作成
            const linkContainer = document.createElement('div');
            linkContainer.className = 'link-container'; // クラスを追加

            const viewLink = document.createElement('a');
            viewLink.href = viewUrl;
            viewLink.textContent = 'View Image';
            viewLink.target = '_blank';

            const deleteLink = document.createElement('a');
            deleteLink.href = deleteUrl;
            deleteLink.textContent = 'Delete Image';
            deleteLink.target = '_blank';

            // URLを画面に追加
            linkContainer.appendChild(viewLink);
            linkContainer.appendChild(document.createElement('br')); // 改行
            linkContainer.appendChild(deleteLink);
            const leftPanel = document.querySelector('.left-panel');
            leftPanel.appendChild(linkContainer);
        } else {
            alert('Image upload failed!');
        }
    })
    .catch(error => {
        console.error('Error uploading image:', error);
    });
});

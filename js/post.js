// Ambil elemen tombol dan form
const addButton = document.querySelector('.add-post-btn');
const addPostForm = document.getElementById('add-post-form');

// Event listener untuk tombol tambah postingan
addButton.addEventListener('click', function(event) {
  event.preventDefault();
  addPostForm.classList.toggle('hidden');
});

// Event listener untuk submit form
postForm.addEventListener('submit', function(event) {
  event.preventDefault();
  // Ambil nilai dari input form
  const title = document.getElementById('title').value;
  const content = document.getElementById('content').value;
  const imageFile = document.getElementById('image-file').files[0];

  // Buat objek FormData untuk mengirim data form dan gambar
  const formData = new FormData();
  formData.append('title', title);
  formData.append('content', content);
  formData.append('image', imageFile);

  // Kirim data form ke server menggunakan AJAX
  const xhr = new XMLHttpRequest();
  xhr.open('POST', '/submit-post');
  xhr.onreadystatechange = function() {
    if (xhr.readyState === XMLHttpRequest.DONE) {
      if (xhr.status === 200) {
        const response = JSON.parse(xhr.responseText);
        console.log(response.message); // Menampilkan pesan respons dari server
        // Tambahkan postingan ke halaman setelah sukses menyimpan ke database
        addPostToPage(response.post);
        // Reset form
        postForm.reset();
        // Sembunyikan form setelah submit
        addPostForm.classList.add('hidden');
      } else {
        console.error('Terjadi kesalahan saat mengirim data ke server');
      }
    }
  };
  xhr.send(formData);
});

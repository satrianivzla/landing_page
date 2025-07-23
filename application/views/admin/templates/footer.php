</div>
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.20/summernote-bs5.min.js"></script>
<script>
    $(document).ready(function() {
        const summernoteConfig = {
            height: "360px",
            toolbar: [
                ['font', ['bold', 'underline', 'clear']],
                ['color', ['color']],
                ['para', ['ul', 'ol', 'paragraph']],
                ['table', ['table']],
                ['insert', ['link', 'picture']],
                ['view', ['fullscreen', 'help']]
            ],
            callbacks: {
                onImageUpload: function(image) {
                    uploadImage(image[0]);
                },
                onMediaDelete : function(target) {
                    deleteImage(target[0].src);
                }
            }
        };

        $('.summernote').summernote(summernoteConfig);

        function uploadImage(image) {
            const data = new FormData();
            data.append("image", image);

            $.ajax({
                url: "<?php echo site_url('admin/upload_image') ?>",
                cache: false,
                contentType: false,
                processData: false,
                data: data,
                type: "POST",
                dataType: "json",
                success: function(response) {
                    $('.summernote').summernote("insertImage", response.url);
                },
                error: function(xhr) {
                    console.error('Image upload failed:', xhr);
                }
            });
        }

        function deleteImage(src) {
            $.ajax({
                data: { src:src },
                type: "POST",
                url: "<?php echo site_url('admin/delete_image') ?>",
                cache: false,
                dataType: "json",
                success: function(response) {
                    // Optionally handle success response
                },
                error: function(xhr) {
                    console.error('Image deletion failed:', xhr);
                }
            });
        }
    });
</script>
</body>
</html>

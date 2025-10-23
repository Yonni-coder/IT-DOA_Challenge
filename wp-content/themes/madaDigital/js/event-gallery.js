jQuery(document).ready(function($) {
    var mediaUploader;
    
    // Ouvrir le media uploader
    $('#add-gallery-images').on('click', function(e) {
        e.preventDefault();
        
        if (mediaUploader) {
            mediaUploader.open();
            return;
        }
        
        mediaUploader = wp.media({
            title: 'Sélectionner des images pour la galerie',
            button: {
                text: 'Ajouter à la galerie'
            },
            multiple: true,
            library: {
                type: 'image'
            }
        });
        
        mediaUploader.on('select', function() {
            var attachments = mediaUploader.state().get('selection').toJSON();
            var currentIds = $('#event-gallery-ids').val();
            var idsArray = currentIds ? currentIds.split(',') : [];
            
            attachments.forEach(function(attachment) {
                if (idsArray.indexOf(attachment.id.toString()) === -1) {
                    idsArray.push(attachment.id);
                    
                    var thumbnailUrl = attachment.sizes && attachment.sizes.thumbnail 
                        ? attachment.sizes.thumbnail.url 
                        : attachment.url;
                    
                    var imageHtml = '<div class="gallery-image-item" data-id="' + attachment.id + '">' +
                                   '<img src="' + thumbnailUrl + '" alt="">' +
                                   '<button type="button" class="remove-gallery-image" title="Supprimer">&times;</button>' +
                                   '</div>';
                    
                    $('#event-gallery-images').append(imageHtml);
                }
            });
            
            $('#event-gallery-ids').val(idsArray.join(','));
            updateImageCount();
        });
        
        mediaUploader.open();
    });
    
    // Supprimer une image
    $(document).on('click', '.remove-gallery-image', function(e) {
        e.preventDefault();
        
        if (!confirm('Supprimer cette image de la galerie ?')) {
            return;
        }
        
        var item = $(this).closest('.gallery-image-item');
        var imageId = item.data('id');
        var currentIds = $('#event-gallery-ids').val();
        var idsArray = currentIds.split(',');
        
        idsArray = idsArray.filter(function(id) {
            return id != imageId;
        });
        
        $('#event-gallery-ids').val(idsArray.join(','));
        item.fadeOut(300, function() {
            $(this).remove();
            updateImageCount();
        });
    });
    
    // Mettre à jour le compteur
    function updateImageCount() {
        var currentIds = $('#event-gallery-ids').val();
        var count = currentIds ? currentIds.split(',').length : 0;
        $('#images-count').text(count);
    }
    
    // Rendre les images triables (drag & drop)
    if ($.fn.sortable) {
        $('#event-gallery-images').sortable({
            placeholder: 'gallery-image-placeholder',
            update: function() {
                var ids = [];
                $('.gallery-image-item').each(function() {
                    ids.push($(this).data('id'));
                });
                $('#event-gallery-ids').val(ids.join(','));
            }
        });
    }
});
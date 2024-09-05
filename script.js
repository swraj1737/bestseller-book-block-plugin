jQuery(document).ready(function ($) {
    function fetchGenres() {
        $.ajax({
            url: biblio_bestsellers_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'biblio_get_genres',
            },
            success: function (response) {
                if (response.success) {
                    var genres = response.data.data.categories;
                    $.each(genres, function (index, genre) {
                        $('.genre-select').append('<option value="' + genre.catUri + '">' + genre.menuText + '</option>');
                    });
                } else {
                    alert('Unable to fetch genres');
                }
            },
        });
    }


    $('.genre-select').on('change', function () {
        var genre = $(this).val();
		$('#book-details').css('display','flex');
		$('.genre-select').val(genre);
        $.ajax({
            url: biblio_bestsellers_ajax.ajax_url,
            type: 'POST',
            data: {
                action: 'biblio_get_best_selling_book',
                genre: genre,
            },
            success: function (response) {
                if (response.success) {
                    var book = response.data[0]; 
                    $('.book-title').text(book.title);
                    $('.book-cover').html('<img src="' + book.bookCover + '" alt="' + book.title + '">');
                    $('.book-authors').text(book.authors.slice(0, 2).join(', '));
                    $('.buy-now-button').attr('href', book.amazonLink);
                } else {
                    alert('Unable to fetch book details');
                }
            },
        });
    });

    // Initialize by fetching the genres
    fetchGenres();
	
	$('.tab-title').on('click', function() {
		// Remove 'active' class from all titles and contents
		$('.tab-title').removeClass('active');
		$('.tab-content').removeClass('active');

		// Add 'active' class to the clicked tab and its corresponding content
		$(this).addClass('active');
		$('#' + $(this).data('tab')).addClass('active');
	});

});

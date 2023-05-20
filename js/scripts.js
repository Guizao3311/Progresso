jQuery(document).ready(function($) {
    var $window = $(window),
        $progressBar = $('#leia-mais-progresso-barra'),
        $toggleButton = $('.leia-mais-progresso-toggle'),
        $content = $('.leia-mais-progresso-conteudo');

    $window.scroll(function() {
        var windowHeight = $window.height(),
            windowScrollTop = $window.scrollTop(),
            documentHeight = $(document).height();

        var progress = (windowScrollTop / (documentHeight - windowHeight)) * 100;

        $progressBar.width(progress + '%');
    });

    $toggleButton.on('click', function() {
        $(this).toggleClass('active');
        $(this).next('.leia-mais-progresso-conteudo').toggleClass('visible');
    });
});

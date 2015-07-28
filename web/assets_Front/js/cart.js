$(document).ready(function(){
    //console.log('chargement du fichier');
    $('#detailCart').on('click','.btn-danger',function(event)
    {
        event.preventDefault();
        console.log('click');
        var $product = $(this).closest('.item-product');

        $.ajax({
            url: $(this).attr('href'),
            dataType: 'json'
        }).done(function(data, textStatus){
            console.log(data);
            console.log(textStatus);
                //suppression de l'element avec fadout en 700s
            $product.fadeOut(700, function()
            {
                // Animation terminé
                $(this).remove();
                // Calculer le nouveau total
                //  prixTotal - = prixTotalProduitSupp
                var totalAllPrice = 0;

                $('.price').each(function(){
                    totalAllPrice += parseFloat($(this).text());
                });

                $('#total').text(totalAllPrice);
            });



        });
    });
});

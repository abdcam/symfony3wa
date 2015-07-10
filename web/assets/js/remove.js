//Meilleur que celui ci dessous en commentaire

$(document).ready(function()
{
    $(".table").on(" click", "btn-danger", function(event)
        {
            var stop_href=confirm("Etes-vous sûr de supprimer ? ");
            if(stop_href==false)
            {
                event.preventDefault();
            }
        }
    )

});


/* $(document).ready(function()
{
    $(".btn-danger").click(function(event)
        {
            var stop_href=confirm("Etes-vous sûr de supprimer ? ");
            if(stop_href==false)
            {
                event.preventDefault();
            }
        })
 });*/
(function($) {
    $.fn.erdraw = function(settings) {
        settings = $.extend({
            //cor: "Teste"
        }, settings);

        //var instance;
        var elements = [];
        var etypes = [];

        $(this).ready(function(){
            //addElement($this, 'box', '<table id="%id%">%conteudo%</table>');
            //addElement($this, 'row', '<tr>%name%</tr>');
        })

        $(this).click(function(){
            //createElement($(this));
        });

        function addElement($this, $name, $html){
            //etypes[0]=$html;
            //alert($html);
        }
        
        function createElement($this) {
            var id = $this.attr('id');
            $('#'+id).append("ooo");
            /*elements.push();
            var temp = '';
            for(var i in elements){
                temp += elements[i];
            }
            alert(temp);*/
        }

        // Todas as ações globais devem ficar dentro desse escopo. Exemplos:
        $(window).scroll(function(e){

        });
        $(window).resize(function(e){
             // ALGUM COMANDO OU FUNÇÃO
        });
        $(document).keydown(function(e){
             // ALGUM COMANDO OU FUNÇÃO
        });
    }
})(jQuery);

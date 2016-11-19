/**
 * Created by musta on 11/19/2016.
 */

interface ImageModOptions{

}

+function($){ //save from polluting root

    class ImageMod{
        public constructor(element: HTMLImageElement, options: ImageModOptions){ 

        }
        imagePath : string ;
        endpoint:  string;

        static DEFAULTS: ImageModOptions = {

        }
    }




$.fn.imageMod = function(option){
        var $this = $(this)
        var data = $this.data('wrsft.mediaview') // namespace: wrsft, type: mediaview
        //only add option to the options structure if it is an object
        var options = $.extend({}, ImageMod.DEFAULTS, $this.data(), typeof option == 'object' && option)


        if(!data) $this.data('wrsft.mediaview', (data = new ImageMod(this, options)))

        if(typeof option == 'string') data[option](options.path)
    }


$.fn.imageMod.constructor = ImageMod;
$.fn.imageMod.data_namespace = "click.wrsft.imagemod"
}(jQuery);

interface JQuery{
    imageMod(command: string): JQuery;
    imageMod(options?: ImageModOptions): JQuery;
}

document.onload = ()=> {
    $("image-mods").on(
        $.fn.imagemod.data_namespace, 
        (evt: JQueryEventObject) => {
            let trgt = $(evt.target)
            if (trgt.is('img') )
            {
                evt.preventDefault();
                trgt.imageMod('show')
            }

    });
};

/**
 * Created by musta on 11/19/2016.
*/
/// <reference path="../typings/mediaview.d.ts" />



interface ImageModOptions{
    imagesourceid: string,
    hiddensourceid: string,
    uploadendpoint: string,
    searchendpoint?: string,
    imagesrcpath?:string,
    ds: string,
    origin: string,
    retrievalendpoint?:string
}

+function($){ //save from polluting root
    const imageModNamespace:string = 'wrsft.imagemodule';
    class ImageMod{

         anchorStub: HTMLAnchorElement;
        // medVw: MediaView;

        public constructor(private element: HTMLImageElement, private options: ImageModOptions){ 
            this.anchorStub = document.createElement("a");
            this.options.imagesrcpath = element.src;
            this.init();
        }

        public init () {
            
            let prx:ImageMod = this;
            let mediaOptions: mediaViewOptions = {
                origin: this.options.origin,
                root: "root" + this.options.ds + "images",
                configEndpoints: (instance:MediaView) => 
                    { (<ImageMod>prx).configureMediaViewEndpoints(instance)} ,
                onSetSelectedFilePath: (instance:MediaView, path:string) => 
                    { (<ImageMod>prx).onMediaViewFileSelectedChanged(instance, path)},
                canManageDir: false,
                canNavigateDir: false,
                ds: this.options.ds
            }

            $(this.anchorStub).mediaview(mediaOptions);

        }

        public launch(){
            this.getMediaView().show();
        }

        private configureMediaViewEndpoints(instance: MediaView){
            instance.options.uploadEndpoint = this.options.uploadendpoint;
            instance.options.searchEndpoint = this.options.searchendpoint;
        }

        private onMediaViewFileSelectedChanged(instance: MediaView, newFilePath: string){
            this.imagePath = newFilePath;
            let srcUrl = this.options.retrievalendpoint + newFilePath ;
            (<HTMLImageElement>$(this.options.imagesourceid)[0]).src = srcUrl;
            let hiddenControl = (<HTMLInputElement>$(this.options.hiddensourceid)[0]);
            hiddenControl.value = newFilePath;
        }

        public getMediaView(){return <MediaView> $(this.anchorStub).data($.fn.mediaviewDataNamespace)}


        imagePath : string ;
        endpoint:  string;

        static DEFAULTS: ImageModOptions = {
            imagesourceid: "",
            hiddensourceid: "",
            uploadendpoint: "",
            ds: "",
            origin: null
        }
    }

$.fn.imageMod = function(option){
        var $this = $(this)
        var data = $this.data(imageModNamespace) // namespace: wrsft, type: mediaview
        //only add option to the options structure if it is an object
        var options = $.extend({}, ImageMod.DEFAULTS, $this.data(), typeof option == 'object' && option)


        if(!data) $this.data(imageModNamespace, (data = new ImageMod(<HTMLImageElement>$this[0], options)))

        data.launch()
    }


$.fn.imageMod.constructor = ImageMod;
$.fn.imageMod.data_namespace = "click.wrsft.imagemod";
}(jQuery);

interface JQuery{
    imageMod(command: string): JQuery;
    imageMod(options?: ImageModOptions): JQuery;
}
/*
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
};*/

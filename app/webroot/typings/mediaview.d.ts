/**
 * Created by musta on 11/14/2016.
 */

interface mediaViewOptions{
    root: string,
    origin: string,
    canManageDir?: boolean,
    canNavigateDir?: boolean,
    configEndpoints: (hInstance: MediaView) => void, //configure all the endpoints
    onSetSelectedFilePath: (MediaView, string) => void, //method invoked if defined, when ever a file is selected
    uploadEndpoint?: string,
    searchEndpoint?: string,
    ds:string
}

interface MediaView{
    options: mediaViewOptions;
    show: any;
}


interface JQuery{
    mediaview(command: string): JQuery;
    mediaview(options?: mediaViewOptions): JQuery;
    mediaviewDataNamespace: string;
}

/*
declare module "mediaview"{
    //xport = mediaView;
}

declare var medvw: MediaView;*/
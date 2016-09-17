/**
 * Created by Mustapha on 5/27/2016.
 */

function controlsValueMatch(element , deuxieme)
{
    //debugger;
    var firstVal = element.value;
    var secondVal = deuxieme.value;

    if(firstVal != secondVal)
    {
        if (secondVal.length > 0)
        {
            deuxieme.setCustomValidity("Passwords Don't Match");
        }
    }
    else
        deuxieme.setCustomValidity('');
}

+function($){
    'use strict';

    // MediaView CLASS DEFINITION
    // ===================
    // triggers should be named as: triggerName.namespacce.componentname
    // ex:click|opening.wrsft.mediaview

    var manageMediaView = '[data-manageMedia=launch]'
    var namespace = 'wrsft'
    var mediaviewNamespace = namespace + '.mediaview'

    var MediaView = function(element, options){
        // variables naming conventions:
        // variables that reference dom element should start with $ character
        //  ex: this.$varName
        // all other variable should not have that character

        //root element of component
        this.$element = $(element);
        this.folders =
        this.files = null
        this.template = '',
        this.options = options,
        this.$modal = null

    }

    MediaView.DEFAULTS = {
        state: 'select', // can be select or save
        path: '',
        origin: window.location.origin +
        ((window.location.hostname.toLowerCase() == 'localhost' ||
             window.location.hostname.toLowerCase() == '127.0.0.1') ? '/demos/worosoft/' : '')
    }

    // define functions on the type prototype
    //ex: MediaView.prototype.funcName = function(){}

    MediaView.prototype.show = function(initialPath){

        initialPath && (this.options.path = initialPath)
        this.initModalControl()
        // show empty modal and background
        this.$modal.show()
        //show win frame
        this.constructFrame()

        this.showLoader()

        //display controls
        this.configureAndDisplayControls()
        //hook events
        this.hookEvts()
        //load data
        var tmpPrx = this
        var folderPath =  this.RetrieveFolderPortion(this.options.path)
        this.getFoldersNdFiles(folderPath, function(){
            //debugger
            var ds = $('input[type=hidden]#ProductHiddends')[0].value
            var filePath = tmpPrx.options.path.replace(folderPath + ds, '')
            tmpPrx.options.pathSelectedFile = filePath.trim()
            tmpPrx = null
        })
    }

    MediaView.prototype.showLoader = function(){

        var modalContent = this.$modal.find('.modal-content')
        var actualHeight = modalContent[0].offsetHeight
        var progressWrapper = this.$modal.find('.progress-wrapper')
        progressWrapper.find('.progress').css('margin-top', actualHeight / 2)
        progressWrapper.removeClass('hide')
    }

    MediaView.prototype.hideLoader = function(){

        var progressWrapper = this.$modal.find('.progress-wrapper')
        progressWrapper.addClass('hide')
    }

    MediaView.prototype.constructFrame = function(){

        var rootContainer = $(this.$modal.find(".modal-dialog"))
        var childCount = rootContainer.children().length

        //init the frame only once
        if(childCount > 0) return

        var ds = $('input[type=hidden]#ProductHiddends')[0].value

        var modalContent = rootContainer.append('<div class="modal-content">' +
        '<div class="modal-header"><span class="pull-left" style="text-transform: uppercase; margin-top: -8px">' +
        '<strong>Manage Media</strong></span>' +
        '<span class="pull-left filesys-path">' +  ds + 'root' + (this.options.path.startsWith(ds) ? this.RetrieveFolderPortion(this.options.path) : (ds + this.RetrieveFolderPortion(this.options.path))) +'</span>' +
        '<span class="close" data-dismiss="modal">close</span></div>' +
        '<span class="filesys-wrapper pull-right filesys-newdir" title="Create a new directory" >' +
            '<span class="glyphicon glyphicon-plus" style="font-size: 25px"></span>' +
            '<span>Create</span>' +
        '</span>'+
        '<span class="filesys-wrapper pull-right filesys-remdir" title="Delete directory" >' +
        '<span class="glyphicon glyphicon-minus" style="font-size: 25px"></span>' +
        '<span>Delete</span>' +
        '</span>'+
        '<div class="modal-body" style="overflow-y: auto;max-height: 200px;">  </div>' +
        '<div class="modal-footer">' +
        '<div class="pull-left"><input type="file" /><a class="btn glyphicon glyphicon-upload" ></a></div><a class="btn btn-primary">Select</a>' +
        '</div>' +
        '</div>' +
        '<div class="progress-wrapper hide"><div class="progress active  progress-striped "><div class="progress-bar" style="width: 100%;"></div></div></div>')
    }

    MediaView.prototype.initModalControl = function(){

        if (this.$modal)return

        var that = $('#mediaview.modal')
        that = that.length && that || $('<div class="modal" name="mediaview" id="mediaview" ><div class="modal-dialog"></div> </div>')
            .appendTo(document.body)

        this.$modal = that
        var modalOptions = {}
        this.$modal.modal(modalOptions, this.$element[0])
        var prx = this

        this.$modal
            .one('hidden.bs.modal', $.proxy(function(){
                prx.unhookEvts()
                prx.$modal = null
            }))
     }

    MediaView.prototype.close = function(){

        //this method call should invoke the hidden.bs.modal evt listener above in initModalControl
        this.unhookEvts()
        $('#mediaview').trigger('click')
    }

    MediaView.prototype.unhookEvts = function(){

        this.$element.off('uploaded.' + mediaviewNamespace)
        this.$element.off('datasync.' + mediaviewNamespace)

        var ipts = this.$modal.find('.modal-dialog .modal-content .modal-footer input[type="file"]')
        var fileInput = $(ipts[0])

        fileInput.off('change.' + mediaviewNamespace)
        fileInput.next().off('click.' + mediaviewNamespace)
        fileInput.parent().next().off('click.' + mediaviewNamespace)
        var modalBody = this.$modal.find('.modal-content > .modal-body')
        modalBody.off('click.' + mediaviewNamespace, '.filesys-wrapper')
        modalBody.off('mouseenter.' + mediaviewNamespace, '.filesys-wrapper')
        modalBody.off('mouseleave.' + mediaviewNamespace, '.filesys-wrapper')

        this.$modal.find('.modal-dialog .modal-content span.filesys-newdir')
            .off('click.' + mediaviewNamespace)
    }

    MediaView.prototype.configureAndDisplayControls = function () {

        var icon = this.$modal.find('.modal-dialog .modal-content .modal-footer a.glyphicon')
        icon.addClass('disabled').attr('disabled', true)
        var fileInput = icon.prev()[0]
        fileInput.files = null
        fileInput.value = ''
        icon.parent().next().addClass('disabled').attr('disabled', true)
    }

    MediaView.prototype.onFileInputChange = function(files){

        var numfiles = files.length
        var icon = this.$modal.find('.modal-dialog .modal-content .modal-footer a.glyphicon')

        if (numfiles < 1){

            icon.addClass('disabled').attr('disabled', true)
            return
        }

        icon.removeClass('disabled').removeAttr('disabled')
    }

    MediaView.prototype.hookEvts = function(){
        var ipts = this.$modal.find('.modal-dialog .modal-content .modal-footer input[type="file"]')
        var fileInput = $(ipts[0])
        var prx = this

        fileInput.on('change.' + mediaviewNamespace, $.proxy(function(){
            prx.onFileInputChange(this.files)
        }))

        var uploadIcon = fileInput.next()

        uploadIcon.on('click.' + mediaviewNamespace, $.proxy(function(){
            prx.upload()
        }))

        uploadIcon.parent().next().on('click.' + mediaviewNamespace, function(){
            prx.selectFile()
        })

        this.$element.on('uploaded.' + mediaviewNamespace, $.proxy(function(){
            fileInput.files = null
            fileInput.value = ''
        }))

        this.$modal.find('.modal-dialog .modal-content span.filesys-newdir')
            .on('click.' + mediaviewNamespace, function(){
                prx.createNewDir() })

        this.$element.on('datasync.' + mediaviewNamespace, $.proxy(function(){

            var modalBody = prx.$modal.find('.modal-content > .modal-body')

            modalBody.off('click.' + mediaviewNamespace, '.filesys-wrapper')
            modalBody.off('mouseenter.' + mediaviewNamespace, '.filesys-wrapper')
            modalBody.off('mouseleave.' + mediaviewNamespace, '.filesys-wrapper')

            var folderPath = prx.getFolderPath()
            var ds = $('input[type=hidden]#ProductHiddends')[0].value || '\\'
            folderPath = folderPath.trim()

             if (folderPath.charAt(0) == ds) folderPath = folderPath.substr(1, folderPath.length - 1)

            var folderTokens = folderPath.split(ds);
            var fileSys = ''

            if (folderTokens.length > 1) {
                var newArr = folderTokens.splice(folderTokens.length - 1, 1)
                var upPath = ds + folderTokens.join(ds)

             fileSys += '<span data-filesystype="updir" class="filesys-wrapper" title="' + upPath + '"><span class="glyphicon -arrow-up" style="font-size: 25px"></span><span class="filesys-name">...</span></span><br />'
            }

            folderTokens = null
            folderPath = null

            prx.folders.forEach(function(pth){
                fileSys += '<span data-filesystype="dir" class="filesys-wrapper" title="'+ pth+'"><span class="glyphicon glyphicon-folder-close" style="font-size: 25px"></span><span class="filesys-name">'+ pth +'</span></span>'
            })

            //this.options.pathSelectedFile
            prx.files.forEach(function(pth){
                //var ad = (prx.options.pathSelectedFile && $.trim(prx.options.pathSelectedFile) == $.trim(pth))  ? ' style="border-color: lightBlue;"': ''
                fileSys += '<span data-filesystype="file"' +
                ' class="filesys-wrapper" title="'+ pth+'">' +
                '<span class="glyphicon glyphicon-file" style="font-size: 25px"></span>' +
                '<span class="filesys-name">'+ pth +'</span>' +
                '</span>'
            })

            var children = modalBody[0].children

            for(var i = children.length - 1; i >= 0; i--)
                modalBody[0].removeChild(children[i])


            $(fileSys).appendTo(modalBody)
            prx.options.pathSelectedFile && prx.setSelectedFile($.trim(prx.options.pathSelectedFile))

            modalBody.on('click.' + mediaviewNamespace, '.filesys-wrapper', $.proxy(function(e){

                var that = $(e.currentTarget)

                if ( that.data('filesystype') == 'updir'){ //Updir clicked
                    var attrPath = that.attr('title')
                    return prx.getFoldersNdFiles(attrPath, function(){prx.setFolderPath(attrPath)})
                }

                var data = that.data('filesysdir.' + namespace)

                if (data && data == true)return

                $(this).css('borderColor', 'lightBlue')
                that.data('filesysdir.' + namespace, data = true)
                var lstclicked = prx.options.lastClicked

                if (lstclicked == undefined || lstclicked == null){
                    prx.options.lastClicked = e.currentTarget
                }else {

                    var oldTest = $(lstclicked).data('filesysdir.' + namespace)
                    $(lstclicked).css('borderColor', 'white')
                    $(lstclicked).data('filesysdir.' + namespace, false)

                    //prx.options.lastClicked = undefined
                    prx.options.lastClicked = e.currentTarget
                }

                var itemType = that.data('filesystype');
                var selectbtn = uploadIcon.parent().next()
                selectbtn.hasClass('disabled') &&  selectbtn.removeClass('disabled').removeAttr('disabled')

                if (itemType == 'dir'){
                    selectbtn[0].text = 'Open'
                }else if (itemType == 'file'){
                    selectbtn[0].text = 'Select'
                }
            }))

            modalBody.on('mouseenter.' + mediaviewNamespace, '.filesys-wrapper', function(){

                if ( $(this).data('filesystype') == 'updir') return

                $(this).css('borderColor', 'blue')
            })

            modalBody.on('mouseleave.' + mediaviewNamespace, '.filesys-wrapper', function(e){

                var that = $(this)

                if ( that.data('filesystype') == 'updir') return

                var data = that.data('filesysdir.' + namespace)

                if(data && data == true ){
                    that.css('borderColor', 'lightBlue')
                    return
                }

                that.css('borderColor', 'white')
            })
        }))
    }

    MediaView.prototype.upload = function(){

        if (this.options.state == 'uploading')return

        this.showLoader()
        this.$element.trigger('uploading.' + mediaviewNamespace)
        this.options.state = 'uploading'
        debugger
        var fileCntrl = this.$modal.find('.modal-dialog .modal-content .modal-footer input[type="file"]')[0]
        var file = fileCntrl.files[0]
        var formData = new FormData()
        formData.append('idia', file)
        formData.append('currentPath', this.getFolderPath())

        $.ajax(this.options.origin + 'FileSystem/uploadFile', {
            dataType: "json",
            crossDomain: true,
            method: 'POST',
            data: formData,
            processData: false,
            context: this,
            jsonp: false,
            contentType: false,
            headers: {
                'Accept': "application/json",
                'x-requested-with': 'XMLHttpRequest'
            },
            success: function (data, textStatus, jqXHR) {
                debugger;
                if(data != null && data.status == "ok")
                {
                    this.files.push(fileName)
                    this.$element.trigger('uploaded.' + mediaviewNamespace);

                }else{
                    (data.message) && alert(data.message)
                }
                this.hideLoader()
                data = null

                this.$element.trigger('datasync.' + mediaviewNamespace)
            },
            error: function (jqXHR, textStatus, errorThrown) {
                debugger;
                alert(textStatus + " " + errorThrown)
                this.hideLoader()
                this.close()
            }
        });
    }

    MediaView.prototype.selectFile = function(){

        if (this.options.lastClicked == undefined || this.options.lastClicked == null)return

        var itemType = $(this.options.lastClicked).data('filesystype')

        if(itemType != 'dir' && itemType != 'file')return

        // if file, get folders path and append filename at the end, set data-pathTarget and return
        if (itemType == 'file'){
            var folderPath = this.getFolderPath()
            var ds = $('input[type=hidden]#ProductHiddends')[0].value || '\\'
            var filename = $(this.options.lastClicked).attr('title')
            folderPath.endsWith(ds) || (folderPath = folderPath + ds)

            this.options.pathSelectedFile = folderPath + filename

            var formData = new FormData()
            formData.append('versionId', $('input[type=hidden]#reqid')[0].value)
            formData.append('file', this.options.pathSelectedFile)

            this.showLoader()

            debugger
            $.ajax(this.options.origin + 'FileSystem/setVersionFilePath', {
                dataType: "json",
                crossDomain: true,
                method: 'POST',
                data: formData,
                processData: false,
                context: this,
                jsonp: false,
                contentType: false,
                headers: {
                    'Accept': "application/json",
                    'x-requested-with': 'XMLHttpRequest'
                },
                success: function (data, textStatus, jqXHR) {
                    debugger;
                    if(data != null && data.status == "ok")
                    {
                        $(this.options.pathtarget)[0].value = this.options.pathSelectedFile
                        this.$element.data('path', this.options.pathSelectedFile)

                    }else{
                        (data.message) && alert(data.message)
                    }
                    this.hideLoader()
                },
                error: function (jqXHR, textStatus, errorThrown) {
                    debugger;
                    alert(textStatus + " " + errorThrown)
                    this.hideLoader()
                }
            });
            return
        }

        var folderPath = this.getFolderPath()
        var ds = $('input[type=hidden]#ProductHiddends')[0].value || '\\'
        var folderName = $(this.options.lastClicked).attr('title')
        folderPath.endsWith(ds) || (folderPath = folderPath + ds)
        folderPath = folderPath + folderName
        var prx = this

        this.getFoldersNdFiles(folderPath, function(){
            prx.setFolderPath(folderPath)
        })

        return

    }

    MediaView.prototype.createNewDir = function(){

        var newDir = prompt("New directory name?")

        if ( newDir == null || newDir == undefined) return

        newDir = newDir.trim()

        if (newDir.length == 0) return

        //todo: ajax create dir, and fetch data
    }

    MediaView.prototype.setSelectedFile = function(filename){

        var foundSpan = this.$modal.find('.modal-content > .modal-body > span[title="'+ filename +'"]')
        foundSpan.css('borderColor', 'lightBlue')
        foundSpan.data('filesysdir.' + namespace, true)
        this.options.lastClicked = foundSpan[0]
    }

    MediaView.prototype.getSelectedFile = function(){}

    MediaView.prototype.getFolderPath = function(){

        return this.$modal.find('.modal-content > .modal-header > .filesys-path').text()
    }

    MediaView.prototype.setFolderPath = function(newPath){

        var ds = $('input[type=hidden]#ProductHiddends')[0].value

        if (newPath.charAt(0) == ds ) {(newPath = newPath.substr(1, newPath.length -1))}

        var tokens = newPath.split(ds)

        if (tokens[0] != 'root')tokens.unshift('root')

        newPath = ds + tokens.join(ds)
        this.$modal.find('.modal-content > .modal-header > .filesys-path').text(newPath)
    }

    MediaView.prototype.RetrieveFolderPortion = function(path){

        if ((path == undefined) || (path == null) || (path.length == undefined) || (path.length == 0)) return

        var ds = $('input[type=hidden]#ProductHiddends')[0].value
        var pathTokens = path.split(ds || '\\')

        if(pathTokens[pathTokens.length -1].split('.').length == 2){
            var tmp =  pathTokens.splice(0, (pathTokens.length -1)).join(ds)
            return tmp
        }

        return path
    }

    MediaView.prototype.getFoldersNdFiles = function(paramPath, callback){

        var ds = $('input[type=hidden]#ProductHiddends')[0].value || '\\'
        var path = paramPath || $.trim(this.options.path)

        if (path.length == 0){
            path = ds + 'root' + ds
        }
        else{

            var pathTokens = path.split(ds)

            var lstEntryLngth = pathTokens[pathTokens.length - 1].split('.').length
            this.options.pathSelectedFile = undefined

            if (lstEntryLngth == 2){ //file
                this.options.pathSelectedFile = pathTokens[pathTokens.length - 1]

                debugger
                path = pathTokens.slice(pathTokens.length - 1).join(ds) + ds

            }else if(lstEntryLngth < 2){ //dir
                if (!path.startsWith(ds + 'root')){
                    if (!path.startsWith('root')){

                        (path.startsWith(ds) && (path = ds + 'root' + path)) || (path = ds + 'root' + ds + path)

                    }else
                    {
                        path = ds + path
                    }
                }
            }
            else{ //invalid
                path = ds + 'root' + ds
            }
        }

        $.ajax(this.options.origin + 'FileSystem/directoryAndFiles', {
            dataType: "json",
            crossDomain: true,
            method: 'GET',
            data: 'path='+ path,
            processData: true,
            context: this,
            jsonp: false,
            contentType: ['application/json','text/json'],
            headers: {
                'Accept': "application/json",
                'Content-Type': 'application/json',
                'x-requested-with': 'XMLHttpRequest'
            },
            success: function (data, textStatus, jqXHR) {
                //debugger;
                if(data != null && data.status == "ok")
                {
                    this.folders = data.filesystem.folders
                    this.files = data.filesystem.files

                }else{
                    (data.message) && alert(data.message)
                    this.folders = []
                    this.files = []
                }
                this.hideLoader()
                data = null

                if (callback)(callback())
                this.$element.trigger('datasync.' + mediaviewNamespace)
            },
            error: function (jqXHR, textStatus, errorThrown) {
                //debugger;
                alert(textStatus + " " + errorThrown)
                this.hideLoader()
                this.close()
            }
        });
    }


    // MediaView PLUGIN DEFINITION
    // =================== this is how html element get extended

    var old = $.fn.mediaview

    $.fn.mediaview = function(option){
        var $this = $(this)
        var data = $this.data('wrsft.mediaview') // namespace: wrsft, type: mediaview
        //only add option to the options structure if it is an object
        var options = $.extend({}, MediaView.DEFAULTS, $this.data(), typeof option == 'object' && option)


        if(!data) $this.data('wrsft.mediaview', (data = new MediaView(this, options)))

        if(typeof option == 'string') data[option](options.path)
    }

    $.fn.mediaview.Constructor = MediaView

    // MediaView NO-CONFLICT
    // =================== common boiler plate code

    $.fn.mediaview.noConflict = function(){
        $.fn.mediaview = old
        return this
    }


    //MediaView DATA API
    //===================

   /* $document.on("", "", function(e){

        e.preventDefault()
    })

    * find all element with the attribute [data-view] with value "mediaview"
    * extend the element to behave as a mediaview component, passing in any data related options

    $(window).on('load', function(){
        $('[data-view="mediaview"]').each(function(){
            var $mediaview = $(this);
            $mediaview.mediaview($mediaview.data())

            // if needs to call some function on the component,
            // call it on its data object with its namespace
            //ex: $mediaview.data('wrsft.mediaview').funcName()
        })
    })*/

    $(document).on('click.' + namespace + '.mediaview.data-api', manageMediaView, function(e){

        var $source = $(e.target)
        $source.is('a') && e.preventDefault()
        $source.mediaview('show')
    })
}(jQuery);
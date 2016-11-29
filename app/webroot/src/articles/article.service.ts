import { Injectable } from '@angular/core';
import { Headers, Http, Response } from '@angular/http';

import 'rxjs/add/operator/toPromise';

import { Article } from './article';

@Injectable()
export class ArticleService {
private _endpoint: string;
    constructor(private http: Http){
    }
  
   public getLatestArticle(): Promise<Article> {
       console.log("Our endpoint is : " + this._endpoint);
       let headers = new Headers();
       headers.set("x-requested-with", "XMLHttpRequest");
      /* return new Promise<Article>(resolve =>
      setTimeout(resolve, 1000)) // delay 2 seconds
      .then(() => this.getDefaultArticle());*/
      return this.http.get(this._endpoint,{ headers: headers})
                    .toPromise()
                    .then( response => this.extractData(response)).catch(this.handleError);
                    //.map(this.extractData)
                    
        
    }

    public get endpoint(): string{ return this._endpoint;}
    public set endpoint(val: string) { this._endpoint = val;} 

    private extractData(res: Response) {
        console.log("services. data arrived: " + res );
        console.debug("response data: ", res);
        let body = res.json();
        console.log("converted body :" +  body);
        //debugger;
        if (body.status == undefined || body.article == undefined)
            return null;
        return body.status == "ok" ? body.article : null; 
        
        //  body.data || { };
    }

    private handleError (error: Response | any){
        debugger;
        // In a real world app, we might use a remote logging infrastructure
        let errMsg: string;
        if (error instanceof Response) {
        const body = error.json() || '';
        const err = body.error || JSON.stringify(body);
        errMsg = `${error.status} - ${error.statusText || ''} ${err}`;
        } else {
        errMsg = error.message ? error.message : error.toString();
        }
        console.error(errMsg);
        //return Observable.throw(errMsg);
    }   
    
    public getDefaultArticle(): Article{
        return  {
            id: 1,
            title: 'Windstorm Relevant News',
            image: "img/cola_leaf.png",
            content: "bonjour"
        };

    }    
}

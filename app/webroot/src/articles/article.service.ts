import { Injectable } from '@angular/core';
import { Headers, Http } from '@angular/http';
import 'rxjs/add/operator/toPromise';
import { Article } from './article';

@Injectable()
export class ArticleService {
endpoint: string;
    constructor(private http: Http){
    }
  
   public getLatestArticle(): Promise<Article> {
       console.log("Our endpoint is : " + this.endpoint);
       return new Promise<Article>(resolve =>
      setTimeout(resolve, 1000)) // delay 2 seconds
      .then(() => this.getDefaultArticle());
        
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

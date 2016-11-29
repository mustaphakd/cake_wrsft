import { Injectable } from '@angular/core';

import { Article } from './article';

@Injectable()
export class ArticleService {
  
   public getLatestArticle(): Promise<Article> {
       return new Promise<Article>(resolve =>
      setTimeout(resolve, 2000)) // delay 2 seconds
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

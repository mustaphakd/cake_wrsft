/**
 * Created by musta on 11/19/2016.
 */

import { Component, NgZone } from '@angular/core';
import { OnInit } from '@angular/core';

import { Article } from './article';
import {ArticleService} from './article.Service';

@Component({
    selector: 'my-art',
    template: `
    <div *ngIf=" canProceed() == true" class="top-grid-left col-md-3">
        <a href="#">
            <img [src]="article?.image" />
        </a>
    </div>
    <div class="top-grid-center col-md-7">
    <h2>{{article?.title}}</h2>
        <p>{{article?.content}}</p> 
    </div>
    `,
    providers: [ ArticleService ]
})/* <h2>{{article.title}}</h2>
        */
export class AppComponent {
    articleAvailable:boolean = false;
    article: Article  ;

    constructor(private zone: NgZone, private articleService: ArticleService){
        //this.article = <Article>{ };
    }

    ngOnInit(): void{
        this.loadArticle();
    }

    private canProceed():boolean{
        if (this.articleAvailable && this.article != null)
            return true;

        return false
    }

    private loadArticle(): void {
        let prx = this;
        this.articleService.getLatestArticle().then(
            art => prx.processResult(art)
        );
    }

    public processResult(art: Article){
        this.zone.run(() =>{
            this.article = art;
            this.articleAvailable = this.article != null;
            console.log("article arrived");
        });
    }
    
}

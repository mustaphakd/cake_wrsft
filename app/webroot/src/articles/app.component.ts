/**
 * Created by musta on 11/19/2016.
 */

import { 
    Component, NgZone, trigger, Input,
    state,  style,  transition,  animate } from '@angular/core';

import { OnInit } from '@angular/core';

import { Article } from './article';
import {ArticleService} from './article.Service';

@Component({
    animations: [
        trigger('articleState', [
            state('unavailable', style({
                transform: 'translatex(100%) scale(.5)'
            })),
            state('available',   style({
                transform: 'translatex(0%) scale(1)'
            })),
            transition('unavailable => available', animate('1000ms ease-in')),
            transition('available => unavailable', animate('1000ms ease-out')),
            /*transition('void => unavailable', [
                style({transform: 'translateX(-100%) scale(1)'}),
                animate(2000)
            ]),
            transition('unavailable => void', [
                animate(1000, style({transform: 'translateX(100%) scale(1)'}))
            ]),*/
            transition('void => available', [
                style({transform: 'translateX(100%) scale(0)'}),
                animate(1000)
            ]),
            transition('available => void', [
                animate(2000, style({transform: 'translateX(0) scale(0)'}))
            ])
        ])
    ],
    selector: 'my-art',
    template: `
    <div class="container" *ngIf=" canProceed() == true" [@articleState] = "getArticleState()"  >
        <div  class="top-grid-left col-md-3" >
            <a href="#">
                <img [src]="article?.image" />
            </a>
        </div>
        <div class="top-grid-center col-md-7">
        <h2>{{article?.title}}</h2>
            <p>{{article?.content}}</p> 
        </div>
    </div>
    `,
    providers: [ ArticleService ]
})
export class AppComponent {
    articleAvailable:boolean = false;
    article: Article  ;
    @Input() endpoint: string = "";

    constructor(private zone: NgZone, private articleService: ArticleService){
    }

    ngOnInit(): void{
        console.log("global var : " + (<any>window).endpoint);
        this.articleService.endpoint = (<any>window).endpoint;
        this.loadArticle();
    }

    private canProceed():boolean{
        if (this.articleAvailable && this.article != null)
            return true;

        return false
    }

    private getArticleState(): string {
        if (this.canProceed())
            return "available";
        return "unavailable";
    }

    private loadArticle(): void {
        let prx = this;
        this.articleService.getLatestArticle().then(
            art => prx.processResult(art)
        );
    }

    public processResult(art: Article){
        debugger;
        this.zone.run(() =>{
            this.article = art;
            this.article.image = "woroimage" + (<any>this.article).image_path;
            this.articleAvailable = this.article != null;
            console.log("article arrived");
        });
    }
    
}

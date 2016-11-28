/**
 * Created by musta on 11/19/2016.
 */

import { Component } from '@angular/core';

export class Article {
    id: number;
    title: string;
    image: string;
    content?: string;
}

@Component({
    selector: 'my-art',
    template: `
    <div class="top-grid-left col-md-3">
        <a href="#">
            <img [src]="article.image" />
        </a>
    </div>
    <div class="top-grid-center col-md-7">
        <h2>{{article.title}}</h2>
        <p>{{article.content}}</p>
    </div>
    `
})
export class AppComponent {
    article: Article = {
        id: 1,
        title: 'Windstorm Relevant News',
        image: "img/cola_leaf.png",
        content: "bonjour"
    };
}

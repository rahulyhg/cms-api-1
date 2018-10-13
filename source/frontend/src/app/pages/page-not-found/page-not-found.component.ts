import { Component, OnInit } from '@angular/core';

@Component({
  selector: 'app-404',
  templateUrl: './404.component.html',
  styleUrls: ['./404.component.scss']
})
export class PageNotFoundComponent {
  links = [
    {icon: 'home', link: '/', caption: 'Goto Home'},
    {icon: 'log-in', link: '/login', caption: 'Login'},
    {icon: 'lock', link: '/register', caption: 'Register'},
  ];
}

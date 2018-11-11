import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../services/auth.service';
import { RpcResponseType } from '../../types/rpc-response.type';
import { Router } from '@angular/router';
import { User } from '../../models/users.model';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: [ './dashboard.component.scss' ]
})
export class DashboardComponent implements OnInit {
  isAllowed = false;
  currentUser: User;

  constructor(
    private userService: AuthService,
    private router: Router
  ) {
  }

  ngOnInit() {
    this.userService.isLoggedIn().subscribe(
      (res: RpcResponseType) => {
        this.isAllowed = res.success;
        this.currentUser = new User(res.result);
      }
    );
  }

  public onLogout(): void {
    this.userService.logout();
    this.router.navigate([ 'login' ]);
  }
}

import { Component, OnInit } from '@angular/core';
import { AuthenticationService } from '../../services/authentication.service';
import { RpcResponseType } from '../../types/rpc.response.type';
import { Router } from '@angular/router';

@Component({
  selector: 'app-dashboard',
  templateUrl: './dashboard.component.html',
  styleUrls: ['./dashboard.component.scss']
})
export class DashboardComponent implements OnInit {
  isAllowed: boolean = false;

  constructor(
    private userService: AuthenticationService,
    private router: Router
  ) { }

  ngOnInit() {
    this.userService.isLoggedIn().subscribe( (res: RpcResponseType) => {
      this.isAllowed = res.success;
      if (!res.success) {
        this.onLogout();
      }
    });
  }

  onLogout() {
    this.userService.logout().subscribe( (res: RpcResponseType) => {
      this.router.navigate(['login']);
    });
  }
}

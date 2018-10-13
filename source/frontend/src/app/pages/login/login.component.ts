import { Component, OnInit } from '@angular/core';
import { AuthenticationService } from '../../services/authentication.service';
import { AppErrorHandler } from '../../services/error-handler';
import { Router } from '@angular/router';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
})
export class LoginComponent implements OnInit {
  errorMessage: string = '';
  isError: boolean = false;
  isLoading: boolean = false;
  credential = {
    email: '',
    password: ''
  };

  constructor(
    private userAuth: AuthenticationService,
    private router: Router
  ) {
  }

  ngOnInit() {
  }

  login( event ) {
    event.preventDefault();
    if (this.isLoading) {
      return false;
    }
    this.isLoading = true;

    this.userAuth.login(
      this.credential.email,
      this.credential.password,
    ).subscribe(
      (res: AppErrorHandler) => {
        this.isLoading = false;
        if (res.result === false) {
          this.isError = true;
          this.errorMessage = res.message;
        } else {
          this.router.navigate(['dashboard']);
        }
      }
    );
  }

  closeAlertMessage(event) {
    this.isError = false;
  }
}

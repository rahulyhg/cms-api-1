import { Component, OnInit } from '@angular/core';
import { AuthenticationService } from '../../services/authentication.service';
import { AppErrorHandler } from '../../services/error-handler';

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

  constructor( private userAuth: AuthenticationService ) {
  }

  ngOnInit() {
  }

  login( event ) {
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
        }
      }
    );
  }

  closeAlertMessage(event) {
    this.isError = false;
  }
}

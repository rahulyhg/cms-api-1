import { Component, Input, OnInit } from '@angular/core';
import { AuthenticationService } from '../../services/authentication.service';
import { AppErrorHandler } from '../../services/error-handler';
import { Router } from '@angular/router';
import { UserCredentialType } from '../../types/user.credential.type';
import { RpcResponseType } from '../../types/rpc.response.type';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
})
export class LoginComponent implements OnInit {
  errorMessage: string = '';
  isError: boolean = false;
  isLoading: boolean = false;
  credential: UserCredentialType = {
    email: '',
    password: ''
  };

  constructor( private userAuth: AuthenticationService,
               private router: Router ) {
  }

  ngOnInit() {
  }

  login( event ) {
    event.preventDefault();
    if (this.isLoading) {
      return false;
    }
    this.isLoading = true;

    this.userAuth.login(this.credential)
      .subscribe(
        ( res: AppErrorHandler|RpcResponseType ) => {
          this.isLoading = false;
          if (res.result === false) {
            this.isError = true;
            this.errorMessage = res.message;
          } else {
            this.router.navigate([ 'dashboard' ]);
          }
        }
      );
  }

  closeAlertMessage( event ) {
    this.isError = false;
  }
}

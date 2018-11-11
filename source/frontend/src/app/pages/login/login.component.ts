import { Component, OnInit } from '@angular/core';
import { AuthService } from '../../services/auth.service';
import { ActivatedRoute, Router } from '@angular/router';
import { OAuthResponse } from '../../types/oauth-response.type';
import { FormBuilder, FormGroup, Validators } from '@angular/forms';
import { OAuthCredentialType } from '../../models/oauth-credential.model';

@Component({
  selector: 'app-login',
  templateUrl: './login.component.html',
})
export class LoginComponent implements OnInit {
  isLoading = false;
  form: FormGroup;
  returnUrl: string;

  constructor(
    private fb: FormBuilder,
    private authService: AuthService,
    private router: Router,
    private route: ActivatedRoute
  ) {
  }

  ngOnInit() {
    this.form = this.fb.group({
      username: [ '', [ Validators.required, Validators.email ] ],
      password: [ '', [ Validators.required, Validators.minLength(6), Validators.maxLength(16) ] ],
    });

    this.authService.logout();
    this.returnUrl = this.route.snapshot.queryParams[ 'returnUrl' ] || 'dashboard';

    // const registeredUser = localStorage.getItem('registeredUser');
    // if (registeredUser) {
    //   localStorage.removeItem('registeredUser');
    //   this.message('success', registeredUser);
    // }
  }

  public login(): void {
    if (this.form.invalid || this.isLoading) {
      return;
    }

    this.isLoading = true;
    this.authService
      .login(new OAuthCredentialType(this.form.value))
      .subscribe(
        ( res: OAuthResponse ) => {
          this.isLoading = false;
          this.router.navigate([ this.returnUrl ]);
        },
      );
  }

  get f() {
    return this.form.controls;
  }

  public fieldClassValidation( fieldName: any ): { valid: boolean, invalid: boolean } {
    const isEdited = this.form.get(fieldName).dirty || this.form.get(fieldName).touched;
    return {
      valid: isEdited && this.form.get(fieldName).valid,
      invalid: isEdited && this.form.get(fieldName).invalid
    };
  }
}

import { Component } from '@angular/core';

@Component({
  selector: 'app-login-footer',
  template: `
      <div class="footer">
          <p>
              <small class="text muted">CodeMZ is powered by Angular6 and Zend Framework<br>&copy; {{year}}
              </small>
          </p>
      </div>
  `,
  styles: [ `.register .footer, .login .footer, .page404 .footer {
      margin-top: 30px;
  }` ]
})
export class LoginFooterComponent {
  year: number;

  constructor() {
    this.year = (new Date()).getFullYear();
  }
}

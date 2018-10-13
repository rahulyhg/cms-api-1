import { Component } from '@angular/core';

@Component({
  selector: 'app-login-footer',
  template: `
      <div class="footer">
          <p>
              <small class="text muted">CodeMZ is powered by Angular6 and Zend Framework<br>&copy; 2014
              </small>
          </p>
      </div>
  `,
  styles: [`.login .footer,.page404 .footer{margin-top: 30px;}`]
})
export class LoginFooterComponent {

  constructor() { }
}

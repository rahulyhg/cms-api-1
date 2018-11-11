import { Component, EventEmitter, Input, Output } from '@angular/core';

@Component({
  selector: 'app-alert',
  templateUrl: './alert.component.html',
  styleUrls: [ './alert.component.scss' ]
})

export class AlertComponent {
  @Input() type = 'error';
  @Input() isShow: boolean;
  @Input() canClose: boolean;

  @Output() onClose: EventEmitter<boolean> = new EventEmitter();

  public close( event: any ): void {
    this.isShow = false;
    this.onClose.emit(true);
  }
}

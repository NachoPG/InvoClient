import { ComponentFixture, TestBed } from '@angular/core/testing';

import { TableAdminUsersComponent } from './table-admin-users.component';

describe('TableAdminUsersComponent', () => {
  let component: TableAdminUsersComponent;
  let fixture: ComponentFixture<TableAdminUsersComponent>;

  beforeEach(async () => {
    await TestBed.configureTestingModule({
      declarations: [ TableAdminUsersComponent ]
    })
    .compileComponents();
  });

  beforeEach(() => {
    fixture = TestBed.createComponent(TableAdminUsersComponent);
    component = fixture.componentInstance;
    fixture.detectChanges();
  });

  it('should create', () => {
    expect(component).toBeTruthy();
  });
});
